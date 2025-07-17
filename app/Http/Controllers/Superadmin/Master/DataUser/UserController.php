<?php

namespace App\Http\Controllers\Superadmin\Master\DataUser;

use App\Http\Controllers\Controller;
use App\Models\Master\Setting;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        // $this->middleware('guest');
        $this->twilioService = $twilioService;
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

        // dd($user);

        return view('superadmin.master.data_user.index', compact('user', 'search', 'entries', 'roles', 'jabatan', 'setting'));
    }

    private function formatPhoneNumber($no_hp)
    {
        // Hilangkan spasi dan karakter non-digit
        $no_hp = preg_replace('/\D/', '', $no_hp);

        // Jika nomor diawali dengan "08", ubah menjadi "+62"
        if (substr($no_hp, 0, 2) === "08") {
            $no_hp = "+62" . substr($no_hp, 1);
        } elseif (substr($no_hp, 0, 3) !== "+62") {
            // Jika tidak dimulai dengan 08 atau +62, tambahkan +62
            $no_hp = "+62" . $no_hp;
        }

        return $no_hp;
    }

    public function tambahdata()
    {
        $setting = Setting::all();

        return view('superadmin.master.data_user.tambah', compact('setting'));
    }

    public function tambah(Request $request)
    {
        // dd($request->all());
        Log::info('Mulai proses pendaftaran');

        try {
            $request->validate([
                'id_setting' => 'required|exists:settings,id',
                'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
                'no_hp' => ['required', 'string', 'unique:users,no_hp', 'regex:/^[0-9]+$/'],
                'password' => ['required', 'string', 'min:6'],
                'role' => 'nullable|in:kolektor,admin_kecamatan,admin_kabupaten',
            ]);

            // Format nomor HP
            $no_hp = $this->formatPhoneNumber($request->no_hp);
            Log::info('Nomor HP setelah diformat: ' . $no_hp);

            // Simpan password asli sebelum di-hash
            $plainPassword = $request->password;

            // Gunakan transaksi untuk menyimpan data
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

                // Kirim pesan konfirmasi pendaftaran
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

                $this->twilioService->sendWhatsAppMessage($no_hp, $welcomeMessage);

                DB::commit();
                return redirect()->route('superadmin.master.user');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Gagal menyimpan user: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Error saat pendaftaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function editdata(Request $request, $id)
    {
        $user = User::with('setting')->findOrFail($id);
        // Ambil semua data setting untuk opsi dropdown
        $settings = Setting::all();

        $pilihSet = optional($user->setting)->id ?? $user->id;

        return view('superadmin.master.data_user.edit', compact('user', 'settings', 'pilihSet'));
    }

    public function edit(Request $request, $id)
    {
        Log::info('Mulai proses pengeditan user', ['user_id' => $id]);

        try {
            $request->validate([
                'id_setting' => 'required|exists:settings,id',
                'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $id],
                'no_hp' => ['required', 'string', 'regex:/^[0-9]+$/', 'unique:users,no_hp,' . $id],
                'password' => ['nullable', 'string', 'min:6'],
                'role' => 'nullable|in:kolektor,admin_kecamatan,admin_kabupaten',
            ]);

            // Format nomor HP
            $no_hp = $this->formatPhoneNumber($request->no_hp);
            Log::info('Nomor HP setelah diformat: ' . $no_hp);

            // Gunakan transaksi untuk menyimpan data
            DB::beginTransaction();
            try {
                // Cari user berdasarkan ID
                $user = User::findOrFail($id);

                // Update data user
                $user->id_setting = $request->id_setting;
                $user->username = $request->username;
                $user->no_hp = $no_hp;
                $user->role = $request->role;
                $user->status = 'A';

                // Update password jika diisi
                if ($request->filled('password')) {
                    $plainPassword = $request->password;
                    $user->password = Hash::make($plainPassword);
                } else {
                    $plainPassword = null; // Password tidak diubah
                }

                $user->save();

                Log::info('User berhasil diperbarui', ['user' => $user]);

                // Kirim pesan konfirmasi perubahan
                $updateMessage = "Halo, *{$user->username}*! 📝\n\n"
                    . "Data akun Anda telah berhasil diperbarui. Berikut adalah detail terbaru:\n"
                    . "🔹 *Username:* {$user->username}\n"
                    . "🔹 *No. HP:* {$user->no_hp}\n"
                    . ($plainPassword ? "🔹 *Password Baru:* {$plainPassword}\n\n" : "\n")
                    . "🔐 *Keamanan Akun:*\n"
                    . "- Silakan login menggunakan Nomor HP/Username dan password Anda.\n"
                    . "- Anda bisa mengganti password kapan saja di pengaturan akun.\n\n"
                    . "📞 Bantuan? Hubungi kami di " . env('NOMOR_CS') . "\n\n"
                    . "Terima kasih telah menggunakan *" . env('NAMA_PERUSAHAAN') . "*! 🚀✨";

                $this->twilioService->sendWhatsAppMessage($no_hp, $updateMessage);

                DB::commit();
                return redirect()->route('superadmin.master.user');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Gagal memperbarui user: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal memperbarui data. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Error saat pengeditan user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function hapus($id)
    {
        User::destroy($id);

        return redirect()->route('superadmin.master.user');
    }
}
