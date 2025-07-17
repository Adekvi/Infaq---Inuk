<?php

namespace App\Http\Controllers\Kolektor\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\User;
use App\Services\TwilioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PengirimanController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
        // Batasi akses hanya untuk role 'petugas'
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'kolektor') {
                abort(403, 'Akses ditolak. Hanya petugas yang diizinkan.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $kecamatan = $request->input('kecamatan');
        $kelurahan = $request->input('kelurahan');
        $rt = $request->input('rt');
        $rw = $request->input('rw');

        // Query dasar untuk Penerimaan
        $query = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->with(['user', 'plotting.kecamatan', 'plotting.kelurahan']);

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('tglSetor', 'LIKE', "%{$search}%")
                    ->orWhere('nominal', 'LIKE', "%{$search}%")
                    ->orWhere('jumlah', 'LIKE', "%{$search}%")
                    ->orWhere('Rt', 'LIKE', "%{$search}%")
                    ->orWhere('Rw', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('username', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('plotting.kecamatan', function ($q3) use ($search) {
                        $q3->where('nama_kecamatan', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('plotting.kelurahan', function ($q3) use ($search) {
                        $q3->where('nama_kelurahan', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter kecamatan
        if ($kecamatan) {
            $query->whereHas('plotting.kecamatan', function ($q) use ($kecamatan) {
                $q->where('db_kecamatans.id', $kecamatan);
            });
        }

        // Filter kelurahan
        if ($kelurahan) {
            $query->whereHas('plotting.kelurahan', function ($q) use ($kelurahan) {
                $q->where('db_kelurahans.id', $kelurahan);
            });
        }

        // Filter Rt
        if ($rt) {
            $query->where('Rt', $rt);
        }

        // Filter Rw
        if ($rw) {
            $query->where('Rw', $rw);
        }

        // Ambil data dengan paginasi
        $kirim = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $kirim->appends([
            'search' => $search,
            'entries' => $entries,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'rt' => $rt,
            'rw' => $rw
        ]);

        // Ambil data untuk dropdown
        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();

        $adminKecamatan = User::where('role', 'admin_kecamatan')->first();

        $noHp = $adminKecamatan->no_hp;

        // Ambil nilai unik Rt dan Rw dari penerimaans
        $rts = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rt')
            ->filter()
            ->sort()
            ->values();
        $rws = Penerimaan::where('id_user', Auth::user()->id)
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rw')
            ->filter()
            ->sort()
            ->values();

        // dd($kirim);

        return view('kolektor.transaksi.pengiriman.index', compact('kirim', 'search', 'entries', 'kecamatans', 'rts', 'rws', 'noHp'));
    }

    private function formatPhoneNumber($no_hp)
    {
        if (empty($no_hp)) {
            return null;
        }

        // Jika nomor sudah dalam format +62 dan valid, kembalikan langsung
        if (preg_match('/^\+62\d{10,13}$/', $no_hp)) {
            return $no_hp;
        }

        // Hilangkan spasi, tanda hubung, dan karakter non-digit
        $no_hp = preg_replace('/\D/', '', $no_hp);

        // Jika nomor diawali dengan "0", hapus "0"
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = substr($no_hp, 1);
        }

        // Tambahkan +62
        $no_hp = '+62' . $no_hp;

        // Validasi panjang nomor (10-13 digit setelah +62)
        if (preg_match('/^\+62\d{10,13}$/', $no_hp)) {
            return $no_hp;
        }

        return null;
    }

    public function kirim(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_penerimaan' => 'required|array',
            'id_penerimaan.*' => 'exists:penerimaans,id',
            'tglSetor' => 'required|date',
            'namaBank' => 'nullable|string|max:255',
            'Rekening' => 'nullable|numeric',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'customMessage' => 'nullable|string',
        ]);

        // Ambil data penerimaan berdasarkan id yang dipilih
        $penerimaans = Penerimaan::whereIn('id', $request->id_penerimaan)->get();

        if ($penerimaans->isEmpty()) {
            return redirect()->back()->withErrors(['id_penerimaan' => 'Data penerimaan tidak ditemukan.']);
        }

        // Proses upload foto
        $fotoPath = null;
        if ($request->hasFile('bukti_foto') && $request->file('bukti_foto')->isValid()) {
            $originalName = $request->file('bukti_foto')->getClientOriginalName();
            $fileName = time() . '_' . str_replace(' ', '_', $originalName);

            if (!Storage::disk('public')->exists('bukti_foto')) {
                Storage::disk('public')->makeDirectory('bukti_foto');
            }

            $fotoPath = $request->file('bukti_foto')->storeAs('bukti_foto', $fileName, 'public');
            Log::info('Foto berhasil diupload', ['path' => $fotoPath]);
        } else {
            Log::warning('Tidak ada file foto yang diupload atau file tidak valid', ['file' => $request->file('bukti_foto')]);
        }

        // Ambil nomor telepon pengguna
        $user = Auth::user();
        $userPhone = $this->formatPhoneNumber($user->no_hp);

        if (!$userPhone) {
            Log::warning('Nomor telepon pengguna tidak valid', ['id_user' => $user->id, 'no_hp' => $user->no_hp]);
            return redirect()->back()->withErrors(['no_hp' => 'Nomor telepon Anda tidak valid. Silakan perbarui profil Anda dengan nomor yang benar (contoh: +6281234567890).']);
        }

        // Ambil nomor telepon admin kecamatan
        $adminKecamatan = User::where('role', 'admin_kecamatan')->first();
        $adminPhone = $adminKecamatan ? $this->formatPhoneNumber($adminKecamatan->no_hp) : null;

        if (!$adminPhone) {
            Log::warning('Nomor telepon admin kecamatan tidak ditemukan atau tidak valid', ['role' => 'admin_kecamatan']);
            return redirect()->back()->withErrors(['no_hp' => 'Nomor telepon admin kecamatan tidak valid atau tidak ditemukan.']);
        }

        // Ambil nama_kelurahan dari relasi plot
        $namaKelurahan = $user->plot ? $user->plot->first()->nama_kelurahan : '-';

        // Gunakan transaksi untuk memastikan data konsisten
        return DB::transaction(function () use ($request, $penerimaans, $fotoPath, $userPhone, $adminPhone, $user, $namaKelurahan) {
            $totalNominal = $penerimaans->sum('nominal');
            $countPenerimaan = $penerimaans->count();
            $userId = $user->id;
            $tglSetor = $request->tglSetor;
            $namaBank = $request->namaBank;
            $rekening = $request->Rekening;
            $customMessage = trim($request->customMessage);

            // Proses pembaruan data secara batch
            $batchSize = 100;
            Penerimaan::whereIn('id', $request->id_penerimaan)
                ->chunk($batchSize, function ($penerimaans) use ($fotoPath, $tglSetor, $namaBank, $rekening) {
                    foreach ($penerimaans as $penerimaan) {
                        $penerimaan->update([
                            'status' => 'Kirim',
                            'bukti_foto' => $fotoPath,
                            'tglSetor' => $tglSetor,
                            'namaBank' => $namaBank,
                            'Rekening' => $rekening ?? null,
                            'updated_at' => now(),
                        ]);
                    }
                    Log::info('Batch pembaruan penerimaan selesai', ['count' => count($penerimaans)]);
                });

            // Siapkan pesan WhatsApp untuk pengguna
            $username = $user->username ?? 'Pengguna';
            $userMessage = "Assalamuallaikum Wr, Wb. *{$username}* 👋\n\n"
                . "Setoran infaq Anda telah *berhasil dikirim*. Berikut adalah detail setoran:\n"
                . "📄 *Jumlah Data:* {$countPenerimaan}\n"
                . "🗓️ *Tanggal Setor:* " . Carbon::parse($tglSetor)->format('d-m-Y') . "\n"
                . "💰 *Total Setoran:* Rp " . number_format($totalNominal, 0, ',', '.') . "\n"
                . "🏦 *Nama Bank:* {$namaBank}\n"
                . "🏧 *No. Rekening:* {$rekening}\n\n"
                . "Terima kasih atas partisipasi dan kepercayaannya 🙏\n"
                . "Jika ada pertanyaan atau butuh bantuan, silakan hubungi kami di *" . env('NOMOR_CS') . "* 📞\n";

            // Siapkan pesan default untuk admin kecamatan
            $defaultAdminMessage = "Assalamuallaikum Wr, Wb. Admin Kecamatan, \n\n"
                . "Setoran infaq dari *{$username}* telah dikirim. Berikut adalah detail setoran:\n"
                . "📍 *Kelurahan:* {$namaKelurahan}\n"
                . "📄 *Jumlah Data:* {$countPenerimaan}\n"
                . "🗓️ *Tanggal Setor:* " . Carbon::parse($tglSetor)->format('d-m-Y') . "\n"
                . "💰 *Total Setoran:* Rp " . number_format($totalNominal, 0, ',', '.') . "\n"
                . "🏦 *Nama Bank:* {$namaBank}\n"
                . "🏧 *No. Rekening:* {$rekening}\n\n"
                . "Mohon verifikasi data setoran. Terima kasih 🙏\n";

            // Tentukan pesan untuk admin kecamatan
            $adminMessage = $defaultAdminMessage;
            if (!empty($customMessage)) {
                $adminMessage .= "\nPesan Kustom:\n{$customMessage}\n";
            }

            // Kirim pesan WhatsApp ke pengguna
            $userMessageSid = $this->twilioService->sendWhatsAppMessage($userPhone, $userMessage);
            if (!$userMessageSid) {
                Log::error('Gagal mengirim pesan WhatsApp ke pengguna', [
                    'id_user' => $userId,
                    'no_hp' => $userPhone,
                    'message' => $userMessage
                ]);
            } else {
                Log::info('Pesan WhatsApp berhasil dikirim ke pengguna', [
                    'sid' => $userMessageSid,
                    'id_user' => $userId,
                    'no_hp' => $userPhone
                ]);
            }

            // Kirim pesan WhatsApp ke admin kecamatan
            $adminMessageSid = $this->twilioService->sendWhatsAppMessage($adminPhone, $adminMessage);
            if (!$adminMessageSid) {
                Log::error('Gagal mengirim pesan WhatsApp ke admin kecamatan', [
                    'no_hp' => $adminPhone,
                    'message' => $adminMessage
                ]);
            } else {
                Log::info('Pesan WhatsApp berhasil dikirim ke admin kecamatan', [
                    'sid' => $adminMessageSid,
                    'no_hp' => $adminPhone
                ]);
            }

            return redirect()->route('kolektor.pengiriman.index')->with('success', 'Data infaq berhasil dikirim dan notifikasi telah dikirim ke WhatsApp.');
        });
    }
}
