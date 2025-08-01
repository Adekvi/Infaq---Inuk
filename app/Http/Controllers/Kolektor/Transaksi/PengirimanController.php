<?php

namespace App\Http\Controllers\Kolektor\Transaksi;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessageJob;
use App\Models\Master\Plotting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\User;
use App\Services\FonnteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PengirimanController extends Controller
{
    protected $fonnteService; // Ubah nama properti

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
        // Batasi akses hanya untuk role 'kolektor'
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

        $user = Auth::user();

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

        // dd($kirim);

        // Ambil data untuk dropdown
        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();

        $adminKecamatan = User::where('role', 'admin_kecamatan')->first();

        $noHp = $adminKecamatan ? $adminKecamatan->no_hp : null;

        // Ambil nama kelurahan unik dari relasi
        $namaKelurahan = $kirim
            ->pluck('plotting.kelurahan.nama_kelurahan') // Ambil semua nama kelurahan
            ->filter() // Hapus null
            ->unique() // Hilangkan duplikat
            ->values()
            ->implode('- '); // Satukan jadi string dipisahkan koma

        // dd($namaKelurahan);

        $rts = Penerimaan::where('id_user', Auth::id())
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rt')
            ->filter()
            ->sort()
            ->values();

        $rws = Penerimaan::where('id_user', Auth::id())
            ->where('status', 'Pending')
            ->distinct()
            ->pluck('Rw')
            ->filter()
            ->sort()
            ->values();

        // dd($rts, $rws);

        return view('kolektor.transaksi.pengiriman.index', compact(
            'kirim',
            'search',
            'entries',
            'kecamatans',
            'rts',
            'rws',
            'noHp',
            'user',
            'namaKelurahan'
        ));
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
        $validated = $request->validate([
            'id_penerimaan' => 'required|array',
            'id_penerimaan.*' => 'exists:penerimaans,id',
            'tglSetor' => 'required|date',
            'namaBank' => 'nullable|string|max:255',
            'Rekening' => 'nullable|numeric',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'customMessage' => 'nullable|string|max:1600',
            'no_hp_admin' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        // Ambil data penerimaan beserta kelurahan
        $penerimaans = Penerimaan::whereIn('id', $request->id_penerimaan)
            ->select('id', 'nominal', 'id_plot')
            ->with([
                'plotting.kelurahan:id,nama_kelurahan'
            ])
            ->get();

        if ($penerimaans->isEmpty()) {
            return redirect()->back()->withErrors(['id_penerimaan' => 'Data penerimaan tidak ditemukan.']);
        }

        // Ambil nama kelurahan unik dari relasi
        $namaKelurahan = $penerimaans
            ->pluck('plotting.kelurahan.nama_kelurahan') // Ambil semua nama kelurahan
            ->filter() // Hapus null
            ->unique() // Hilangkan duplikat
            ->values()
            ->implode('- '); // Satukan jadi string dipisahkan koma

        $rtList = $penerimaans
            ->pluck('plotting.Rt')
            ->filter()
            ->unique()
            ->values()
            ->implode(', ');

        $rwList = $penerimaans
            ->pluck('plotting.Rw')
            ->filter()
            ->unique()
            ->values()
            ->implode(', ');

        // dd($namaKelurahan);

        // Proses upload foto
        $fotoPath = null;
        $mediaUrl = null;
        if ($request->hasFile('bukti_foto') && $request->file('bukti_foto')->isValid()) {
            $fileSize = $request->file('bukti_foto')->getSize();
            Log::info('File size', ['size' => $fileSize / 1024 . ' KB']);
            $fileName = time() . '_' . str_replace(' ', '_', $request->file('bukti_foto')->getClientOriginalName());
            $fotoPath = $request->file('bukti_foto')->storeAs('bukti_foto', $fileName, 'public');
            $mediaUrl = asset('storage/' . $fotoPath);
            $mediaUrl = str_replace('http://127.0.0.1:8000', config('app.url'), $mediaUrl);
            Log::info('Foto berhasil diupload', ['path' => $fotoPath, 'mediaUrl' => $mediaUrl]);
        }

        // Ambil nomor telepon kolektor
        $user = Auth::user();
        $userPhone = $this->formatPhoneNumber($user->no_hp);
        Log::info('Formatted user phone', ['userPhone' => $userPhone]);
        if (!$userPhone) {
            Log::error('Nomor telepon kolektor tidak valid', ['no_hp' => $user->no_hp]);
            return redirect()->back()->withErrors(['no_hp' => 'Nomor telepon Anda tidak valid.']);
        }

        $adminPhone = Cache::remember('admin_phone', now()->addHours(24), function () use ($request) {
            if ($request->filled('no_hp_admin')) {
                $adminPhone = $this->formatPhoneNumber($request->no_hp_admin);
                Log::info('Formatted admin phone from input', ['adminPhone' => $adminPhone]);
                return $adminPhone;
            }
            $adminKecamatan = User::where('role', 'admin_kecamatan')->first();
            $adminPhone = $adminKecamatan ? $this->formatPhoneNumber($adminKecamatan->no_hp) : null;
            Log::info('Formatted admin phone from database', ['adminPhone' => $adminPhone]);
            return $adminPhone;
        });

        if (!$adminPhone) {
            return redirect()->back()->withErrors(['no_hp_admin' => 'Nomor telepon admin kecamatan tidak valid.']);
        }

        // Update massal data penerimaan
        Penerimaan::whereIn('id', $request->id_penerimaan)->update([
            'status' => 'Kirim',
            'bukti_foto' => $fotoPath,
            'tglSetor' => $request->tglSetor,
            'namaBank' => $request->namaBank ?? 'Tidak ditentukan',
            'Rekening' => $request->Rekening ?? 'Tidak ditentukan',
            'updated_at' => now(),
        ]);

        // Siapkan data untuk job pengiriman pesan
        $totalNominal = $penerimaans->sum('nominal');
        $countPenerimaan = $penerimaans->count();

        // Pesan untuk kolektor (tetap sama)
        $userMessage = "Assalamuallaikum Wr, Wb. *{$user->username}* 👋\n\n"
            . "Setoran infaq Anda telah *berhasil dikirim*. Berikut adalah detail setoran:\n"
            . "📄 *Jumlah Data:* {$countPenerimaan}\n"
            . "🗓️ *Tanggal Setor:* " . Carbon::parse($request->tglSetor)->format('d-m-Y') . "\n"
            . "💰 *Total Setoran:* Rp " . number_format($totalNominal, 0, ',', '.') . "\n"
            . "🏦 *Nama Bank:* {$request->namaBank}\n"
            . "🏧 *No. Rekening:* {$request->Rekening}\n\n"
            . "Terima kasih atas partisipasi dan kepercayaannya 🙏\n"
            . "Jika ada pertanyaan atau butuh bantuan, silakan hubungi kami di *" . env('NOMOR_CS') . "* 📞\n";

        // Pesan default untuk admin
        $defaultMessage = "Assalamuallaikum Wr, Wb. Admin Kecamatan,\n\n"
            . "Setoran infaq dari *{$user->username}* telah dikirim. Berikut adalah detail setoran:\n"
            . "📍 *Kelurahan:* {$namaKelurahan}\n"
            . "🏠 *RT:* {$rtList}\n"
            . "🏠 *RW:* {$rwList}\n"
            . "📄 *Jumlah Data:* {$countPenerimaan}\n"
            . "🗓️ *Tanggal Setor:* " . Carbon::parse($request->tglSetor)->format('d-m-Y') . "\n"
            . "💰 *Total Setoran:* Rp " . number_format($totalNominal, 0, ',', '.') . "\n"
            . "🏦 *Nama Bank:* {$request->namaBank}\n"
            . "🏧 *No. Rekening:* {$request->Rekening}\n\n"
            . ($mediaUrl ? "📎 *Bukti Transfer:* Lihat lampiran\n" : "")
            . "Mohon verifikasi data setoran. Terima kasih 🙏\n";

        // Tentukan pesan untuk admin berdasarkan input customMessage
        $adminMessage = $request->filled('customMessage') ? $request->customMessage : $defaultMessage;

        // Di bagian pengiriman pesan
        Log::info('Preparing to dispatch WhatsApp messages', [
            'userPhone' => $userPhone,
            'adminPhone' => $adminPhone,
            'mediaUrl' => $mediaUrl,
            'adminMessage' => $adminMessage
        ]);

        // Dispatch job untuk pengiriman pesan WhatsApp
        SendWhatsAppMessageJob::dispatchSync($userPhone, $userMessage);
        SendWhatsAppMessageJob::dispatchSync($adminPhone, $adminMessage, $mediaUrl);

        Log::info('WhatsApp message jobs dispatched');

        return redirect()->route('kolektor.pengiriman.index')->with('success', 'Data infaq berhasil dikirim dan notifikasi akan dikirim ke WhatsApp.');
    }
}
