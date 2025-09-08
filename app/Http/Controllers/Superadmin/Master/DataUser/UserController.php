<?php

namespace App\Http\Controllers\Superadmin\Master\DataUser;

use App\Http\Controllers\Controller;
use App\Models\Master\Plotting;
use App\Models\Master\Setting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use App\Models\User;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        // $this->middleware('guest');
        $this->fonnteService = $fonnteService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);
        $roles = $request->input('roles');
        $jabatan = $request->input('jabatan');

        $query = User::with('setting')
            ->where('role', '!=', 'superadmin')
            ->orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('no_hp', 'LIKE', "%{$search}%")
                    ->orWhere('password', 'LIKE', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%")
                    ->orWhereHas('setting', function ($q2) use ($search) {
                        $q2->where('namasetting', 'LIKE', "%{$search}%");
                    });
            });
        }

        // ✅ Filter berdasarkan role
        if ($roles) {
            $query->where('role', 'LIKE', "%{$roles}%");
        }

        // Filter berdasarkan namasetting
        if ($jabatan) {
            $query->whereHas('setting', function ($q) use ($jabatan) {
                $q->where('namasetting', 'LIKE', "%{$jabatan}%");
            });
        }

        $user = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $user->appends(['search' => $search, 'entries' => $entries, 'roles' => $roles, 'jabatan' => $jabatan]);

        // Ambil data untuk dropdown
        $setting = Setting::all();

        // dd($setting);

        return view('superadmin.master.data_user.index', compact('user', 'search', 'entries', 'roles', 'jabatan', 'setting'));
    }

    private function formatPhoneNumber($no_hp)
    {
        // Hilangkan spasi dan karakter non-digit kecuali tanda +
        $no_hp = preg_replace('/[^0-9+]/', '', $no_hp);

        // Jika nomor sudah diawali +62, biarkan
        if (substr($no_hp, 0, 3) === '+62') {
            return $no_hp;
        }

        // Jika nomor diawali dengan 08, ubah menjadi +62
        if (substr($no_hp, 0, 2) === '08') {
            return '+62' . substr($no_hp, 1);
        }

        // Jika tidak diawali +62 atau 08, tambahkan +62
        if (substr($no_hp, 0, 1) !== '+') {
            return '+62' . $no_hp;
        }

        return $no_hp;
    }

    public function updateStatus(Request $request)
    {
        $userId = $request->input('id');
        $newStatus = $request->has('status') ? 'A' : 'N';

        $user = User::findOrFail($userId);
        $user->status = $newStatus;
        $user->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        $setting = Setting::all();
        $kecamatans = Db_kecamatan::where('status', 'Aktif')->get();
        $kelurahans = Db_kelurahan::all();

        return view('superadmin.master.data_user.tambah', compact('setting', 'kecamatans', 'kelurahans'));
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanId = $request->input('id_kecamatan');
        $kelurahans = Db_kelurahan::where('id_kecamatan', $kecamatanId)->get();
        return response()->json($kelurahans);
    }

    public function tambah(Request $request)
    {
        Log::info('Mulai proses pendaftaran', ['request' => $request->all()]);

        try {
            // Validasi input
            $request->validate([
                'id_setting' => 'required|exists:settings,id',
                'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
                'no_hp' => ['required', 'string', 'unique:users,no_hp', 'regex:/^[0-9]+$/'],
                'password' => ['required', 'string', 'min:6'],
                'role' => 'required|in:kolektor,admin_kecamatan,admin_kabupaten',
                'id_kecamatan' => 'required_if:role,kolektor,admin_kecamatan|exists:db_kecamatans,id',
                'id_kelurahan' => 'required_if:role,kolektor|nullable|exists:db_kelurahans,id',
                'rt' => 'required_if:role,kolektor|array',
                'rw' => 'required_if:role,kolektor|array',
            ]);

            // Format nomor HP
            $no_hp = $this->formatPhoneNumber($request->no_hp);
            Log::info('Nomor HP setelah diformat: ' . $no_hp);

            $plainPassword = $request->password;

            DB::beginTransaction();
            try {
                // Simpan user ke tabel users
                $user = new User();
                $user->id_setting = $request->id_setting;
                $user->username = $request->username;
                $user->no_hp = $no_hp;
                $user->password = Hash::make($plainPassword);
                $user->role = $request->role;
                $user->status = 'A';
                $user->save();

                Log::info('User berhasil dibuat', ['user' => $user]);

                // Kirim pesan WhatsApp
                $welcomeMessage = "Halo, *{$user->username}*! 🎉\n\n"
                    . "Akun Anda telah berhasil dibuat. Berikut adalah detail login Anda:\n"
                    . "🔹 *Username:* {$user->username}\n"
                    . "🔹 *No. HP:* {$user->no_hp}\n\n"
                    . "🔹 *Password:* {$plainPassword}\n\n"
                    . "🔐 *Keamanan Akun:*\n"
                    . "- Silakan login menggunakan Nomor HP/Username dan password yang Anda buat.\n"
                    . "- Anda bisa mengganti password kapan saja di pengaturan akun.\n\n"
                    . "📞 Bantuan? Hubungi kami di " . env('NOMOR_CS') . "\n\n"
                    . "Terima kasih telah bergabung dengan *" . env('NAMA_PERUSAHAAN') . "*! 🚀✨";

                $this->fonnteService->sendWhatsAppMessage($no_hp, $welcomeMessage);

                // Simpan plotting untuk role kolektor atau admin_kecamatan
                if (in_array($user->role, ['kolektor', 'admin_kecamatan'])) {
                    // Cek apakah data diri diperlukan
                    $dataDiri = Datadiri::where('id_user', $user->id)->first();

                    // Siapkan data untuk tabel plotting
                    $plottingData = [
                        'id_user' => $user->id,
                        'id_datadiri' => $dataDiri ? $dataDiri->id : null,
                        'id_kecamatan' => $request->id_kecamatan,
                    ];

                    // Tambahkan Rt dan Rw hanya untuk kolektor
                    if ($user->role === 'kolektor') {
                        $plottingData['Rt'] = json_encode($request->rt);
                        $plottingData['Rw'] = json_encode($request->rw);
                    } else {
                        $plottingData['Rt'] = null;
                        $plottingData['Rw'] = null;
                    }

                    $plotting = Plotting::create($plottingData);

                    // Simpan kelurahan hanya untuk kolektor
                    if ($user->role === 'kolektor' && $request->filled('id_kelurahan')) {
                        $plotting->kelurahan()->sync([$request->id_kelurahan]);
                    }

                    Log::info('Plotting berhasil disimpan', ['plotting' => $plotting]);
                }

                DB::commit();
                return redirect()->route('superadmin.master.user')->with('success', 'User berhasil ditambahkan.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Gagal menyimpan user atau plotting: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
                return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            Log::error('Error saat validasi pendaftaran: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan validasi: ' . $e->getMessage());
        }
    }

    public function editdata(Request $request, $id)
    {
        $user = User::with('setting')->findOrFail($id);
        $settings = Setting::all();
        $pilihSet = optional($user->setting)->id ?? $user->id_setting;

        // Fetch plotting related to the user
        $plotting = Plotting::with(['kecamatan', 'kelurahan'])->where('id_user', $user->id)->first();

        // Ambil semua kecamatan
        $kecamatan = Db_kecamatan::all();

        // Ambil kelurahan berdasarkan id_kecamatan dari plotting, jika ada
        $kelurahan = $plotting && $plotting->id_kecamatan
            ? Db_kelurahan::where('id_kecamatan', $plotting->id_kecamatan)->get()
            : collect();

        // Ambil ID kecamatan dan kelurahan sebagai data tunggal
        $pilihKec = $plotting ? $plotting->id_kecamatan : null;
        $pilihKel = ($plotting && $user->role === 'kolektor' && $plotting->id_kelurahan)
            ? $plotting->id_kelurahan
            : null;

        // Decode JSON untuk RT dan RW, hanya untuk kolektor
        $rts = ($plotting && $user->role === 'kolektor' && $plotting->rt) ? json_decode($plotting->rt, true) : [];
        $rws = ($plotting && $user->role === 'kolektor' && $plotting->rw) ? json_decode($plotting->rw, true) : [];

        return view('superadmin.master.data_user.edit', compact(
            'user',
            'settings',
            'pilihSet',
            'kecamatan',
            'kelurahan',
            'plotting',
            'rts',
            'rws',
            'pilihKec',
            'pilihKel'
        ));
    }

    public function edit(Request $request, $id)
    {
        Log::info('Mulai proses update user', [
            'user_id' => $id,
            'request_data' => $request->all()
        ]);

        try {
            // Validasi input
            $request->validate([
                'id_setting' => 'required|exists:settings,id',
                'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $id],
                'no_hp' => ['required', 'string', 'unique:users,no_hp,' . $id, 'regex:/^\+?[0-9]{10,15}$/'],
                'password' => ['nullable', 'string', 'min:6'],
                'role' => 'required|in:kolektor,admin_kecamatan,admin_kabupaten',
                'id_kecamatan' => 'required_if:role,kolektor,admin_kecamatan|exists:db_kecamatans,id',
                'id_kelurahan' => 'required_if:role,kolektor|nullable|exists:db_kelurahans,id',
                'rt' => 'required_if:role,kolektor|array',
                'rw' => 'required_if:role,kolektor|array',
            ], [
                'no_hp.regex' => 'Nomor telepon harus berupa angka dengan panjang 10-15 digit, boleh diawali dengan tanda +.',
            ]);

            Log::info('Validasi berhasil', ['request_data' => $request->all()]);

            $user = User::findOrFail($id);

            DB::beginTransaction();
            try {
                // Simpan data user sebelum pembaruan
                Log::info('Data user sebelum update', ['user' => $user->toArray()]);

                // Update user
                $user->id_setting = $request->id_setting;
                $user->username = $request->username;
                $user->no_hp = $this->formatPhoneNumber($request->no_hp);
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                $user->email = $request->email;
                $user->role = $request->role;
                $user->save();

                Log::info('User berhasil diupdate', ['user' => $user->toArray()]);

                // Update atau buat plotting
                if (in_array($user->role, ['kolektor', 'admin_kecamatan'])) {
                    $dataDiri = Datadiri::where('id_user', $user->id)->first();

                    $plottingData = [
                        'id_user' => $user->id,
                        'id_datadiri' => $dataDiri ? $dataDiri->id : null,
                        'id_kecamatan' => $request->id_kecamatan,
                        'id_kelurahan' => $user->role === 'kolektor' ? $request->id_kelurahan : null,
                        'Rt' => $user->role === 'kolektor' ? json_encode($request->rt) : null,
                        'Rw' => $user->role === 'kolektor' ? json_encode($request->rw) : null,
                    ];

                    $plotting = Plotting::where('id_user', $user->id)->first();

                    Log::info('Data plotting sebelum update', [
                        'plotting_exists' => $plotting ? true : false,
                        'plotting_data' => $plotting ? $plotting->toArray() : null,
                        'new_plotting_data' => $plottingData
                    ]);

                    if ($plotting) {
                        $updated = $plotting->update($plottingData);
                        Log::info('Plotting update status', [
                            'updated' => $updated,
                            'plotting_data' => $plotting->fresh()->toArray()
                        ]);
                    } else {
                        $plotting = Plotting::create($plottingData);
                        Log::info('Plotting baru berhasil dibuat', ['plotting' => $plotting->toArray()]);
                    }
                } else {
                    Plotting::where('id_user', $user->id)->delete();
                    Log::info('Plotting dihapus karena role bukan kolektor atau admin_kecamatan', ['user_id' => $user->id]);
                }

                DB::commit();
                Log::info('Transaksi berhasil disimpan');
                return redirect()->route('superadmin.master.user')->with('success', 'User berhasil diupdate.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Gagal menyimpan user atau plotting: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            Log::error('Error saat validasi update: ' . $e->getMessage(), ['stack' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan validasi: ' . $e->getMessage());
        }
    }

    public function hapus($id)
    {
        User::destroy($id);

        return redirect()->route('superadmin.master.user');
    }
}
