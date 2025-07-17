<?php

namespace App\Http\Controllers\Petugas\Setor;

use App\Http\Controllers\Controller;
use App\Models\db_kelurahan_petugas;
use App\Models\Master\Petugas\Db_petugas;
use App\Models\Role\Db_hasilinfaq;
use App\Models\Role\Petugas\Db_setorinfaq;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KirimController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
        // Batasi akses hanya untuk role 'petugas'
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'petugas') {
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
        $id_kecamatan = $request->input('id_kecamatan');
        $id_kelurahan = $request->input('id_kelurahan');

        // Ambil petugas berdasarkan user yang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Ambil wilayah tugas petugas
        $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
            ->with(['kecamatan', 'kelurahan'])
            ->get();

        // Ambil daftar kecamatan dan kelurahan yang terkait dengan wilayah tugas
        $kecamatans = $wilayahTugas->pluck('kecamatan')->unique('id');
        $kelurahans = $wilayahTugas->pluck('kelurahan')->unique('id');

        // Daftar bulan untuk tampilan
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        // Query dasar untuk Db_setorinfaq, hanya untuk petugas yang login dan status 'S'
        $query = Db_hasilinfaq::where('id_user', Auth::user()->id)
            ->where('status', 'K')
            ->with(['user', 'petugas.wilayahTugas.kecamatan', 'petugas.wilayahTugas.kelurahan', 'kecamatan', 'kelurahan', 'setor']);

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('jenis_infaq', 'LIKE', "%{$search}%")
                    ->orWhere('jumlah', 'LIKE', "%{$search}%")
                    ->orWhere('total', 'LIKE', "%{$search}%")
                    ->orWhere('keterangan', 'LIKE', "%{$search}%")
                    ->orWhereHas('petugas', function ($q2) use ($search) {
                        $q2->where('nama_petugas', 'LIKE', "%{$search}%")
                            ->orWhereHas('user', function ($q3) use ($search) {
                                $q3->where('username', 'LIKE', "%{$search}%");
                            });
                    });
            });
        }

        // Filter berdasarkan kecamatan dan kelurahan
        if ($id_kecamatan || $id_kelurahan) {
            $query->whereHas('petugas.wilayahTugas', function ($q2) use ($id_kecamatan, $id_kelurahan, $petugas) {
                $q2->where('id_petugas', $petugas->id);
                if ($id_kecamatan) {
                    $q2->where('id_kecamatan', $id_kecamatan);
                }
                if ($id_kelurahan) {
                    $q2->where('id_kelurahan', $id_kelurahan);
                }
            });
        }

        // Ambil data dengan paginasi
        $hasilinfaq = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $hasilinfaq->appends(['search' => $search, 'entries' => $entries, 'id_kecamatan' => $id_kecamatan, 'id_kelurahan' => $id_kelurahan]);

        // dd($hasilinfaq);

        return view('petugas.lapor.index', compact('hasilinfaq', 'search', 'entries', 'kecamatans', 'kelurahans', 'id_kecamatan', 'id_kelurahan', 'petugas', 'months'));
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
            'id_setor' => 'required|array',
            'id_setor.*' => 'exists:db_setorinfaqs,id',
            'no_hp' => 'nullable|string|regex:/^[0-9]+$/',
            'tgl_kirim' => 'required|date',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Ambil petugas berdasarkan user yang login
        $petugas = Db_petugas::where('id_user', Auth::user()->id)->firstOrFail();

        // Ambil semua setoran yang dipilih dengan status 'S'
        $setorans = Db_setorinfaq::where('id_user', Auth::user()->id)
            ->whereIn('id', $request->id_setor)
            ->where('status', 'S')
            ->get();

        if ($setorans->isEmpty()) {
            return redirect()->back()->withErrors(['id_setor' => 'Tidak ada setoran valid dengan status Setor yang dipilih.']);
        }

        // Verifikasi wilayah tugas untuk setiap setoran
        foreach ($setorans as $setoran) {
            $wilayahTugas = db_kelurahan_petugas::where('id_petugas', $petugas->id)
                ->where('id_kecamatan', $setoran->id_kecamatan)
                ->where('id_kelurahan', $setoran->id_kelurahan)
                ->exists();

            if (!$wilayahTugas) {
                return redirect()->back()->withErrors([
                    'id_setor' => "Setoran ID {$setoran->id} memiliki kecamatan atau kelurahan yang tidak termasuk dalam wilayah tugas Anda."
                ]);
            }
        }

        // Proses upload foto
        $fotoPath = null;
        if ($request->hasFile('bukti_foto') && $request->file('bukti_foto')->isValid()) {
            $originalName = $request->file('bukti_foto')->getClientOriginalName();
            $fileName = time() . '_' . str_replace(' ', '_', $originalName);

            if (!Storage::disk('public')->exists('kirim/bukti_kirim')) {
                Storage::disk('public')->makeDirectory('kirim/bukti_kirim');
            }

            $fotoPath = $request->file('bukti_foto')->storeAs('kirim/bukti_kirim', $fileName, 'public');
            Log::info('Foto berhasil diupload', ['path' => $fotoPath]);
        } else {
            Log::warning('Tidak ada file foto yang diupload atau file tidak valid', ['file' => $request->file('bukti_foto')]);
        }

        // Ambil nomor telepon pengguna dari tabel users dan format
        $user = Auth::user();
        $userPhone = $this->formatPhoneNumber($user->no_hp);

        if (!$userPhone) {
            Log::warning('Nomor telepon pengguna tidak valid', ['id_user' => $user->id, 'no_hp' => $user->no_hp]);
            return redirect()->back()->withErrors(['no_hp' => 'Nomor telepon Anda tidak valid. Silakan perbarui profil Anda dengan nomor yang benar (contoh: +6281234567890).']);
        }

        // Format no_hp dari input form (jika ada)
        $inputPhone = $request->no_hp ? $this->formatPhoneNumber($request->no_hp) : null;

        // Gunakan transaksi untuk memastikan data konsisten
        DB::transaction(function () use ($request, $setorans, $petugas, $fotoPath, $userPhone, $user, $inputPhone) {
            $totalJumlah = $setorans->sum('jumlah');
            $countSetoran = $setorans->count();
            $userId = $user->id;
            $petugasId = $petugas->id;
            $tglKirim = $request->tgl_kirim;

            // Siapkan data untuk bulk insert ke db_hasilinfaqs
            $hasilinfaqData = $setorans->map(function ($setoran) use ($userId, $petugasId, $inputPhone, $tglKirim, $fotoPath) {
                return [
                    'id_user' => $userId,
                    'id_petugas' => $petugasId,
                    'id_kecamatan' => $setoran->id_kecamatan,
                    'id_kelurahan' => $setoran->id_kelurahan,
                    'id_setor' => $setoran->id,
                    'no_hp' => $inputPhone,
                    'tgl_kirim' => $tglKirim,
                    'bukti_foto' => $fotoPath,
                    'status' => 'K',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            // Bulk insert ke db_hasilinfaqs
            Db_hasilinfaq::insert($hasilinfaqData);

            // Bulk update status di db_setorinfaqs menjadi 'A'
            Db_setorinfaq::whereIn('id', $request->id_setor)
                ->where('status', 'S')
                ->update(['status' => 'A']);

            // Kirim pesan WhatsApp ke nomor pengguna dari tabel users
            $username = $user->username ?? 'Pengguna';
            $messageBody = "Assalamuallaikum Wr, Wb. *{$username}* 👋\n\n"
                . "Setoran infaq Anda telah *berhasil dikirim*. Berikut adalah detail setoran:\n"
                . "📄 *Jumlah Data:* {$countSetoran}\n"
                . "🗓️ *Tanggal Setor:* " . \Carbon\Carbon::parse($tglKirim)->format('d-m-Y') . "\n"
                . "💰 *Total Setoran:* Rp " . number_format($totalJumlah, 0, ',', '.') . "\n\n"
                . "Terima kasih atas partisipasi dan kepercayaannya 🙏\n"
                . "Jika ada pertanyaan atau butuh bantuan, silakan hubungi kami di *" . env('NOMOR_CS') . "* 📞\n";

            $messageSid = $this->twilioService->sendWhatsAppMessage($userPhone, $messageBody);

            if (!$messageSid) {
                Log::error('Gagal mengirim pesan WhatsApp', [
                    'id_user' => $userId,
                    'no_hp' => $userPhone,
                    'message' => $messageBody
                ]);
                // Tidak redirect error, hanya log, agar transaksi tidak dibatalkan
            } else {
                Log::info('Pesan WhatsApp berhasil dikirim', [
                    'sid' => $messageSid,
                    'id_user' => $userId,
                    'no_hp' => $userPhone
                ]);
            }
        });

        return redirect()->route('petugas.input.infaq')->with('success', 'Data setoran berhasil dikirim!.');
    }
}
