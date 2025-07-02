<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profil\Datadiri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function lupa()
    {
        return view('auth.password.lupa-password');
    }

    public function index()
    {
        // dd(session()->all());
        return view('auth/login');
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

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'identifier' => 'required',
            'password' => 'required'
        ]);

        $identifier = $request->identifier;

        // Cek apakah input adalah nomor HP atau username
        if (is_numeric($identifier)) {
            $identifier = $this->formatPhoneNumber($identifier);
            $credentials = ['no_hp' => $identifier, 'password' => $request->password];
            $user = User::where('no_hp', $identifier)->first();
        } else {
            $credentials = ['username' => $identifier, 'password' => $request->password];
            $user = User::where('username', $identifier)->first();
        }

        // Cek apakah user ada
        if (!$user) {
            return redirect()->back()->withErrors(['identifier' => 'No. Handphone atau Username belum terdaftar. Silahkan Registrasi dahulu!'])->withInput();
        }

        // Cek autentikasi
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            switch (Auth::user()->role) {
                case 'superadmin':
                    return redirect()->route('superadmin.dashboard');
                case 'petugas':
                    // Cek apakah identitas sudah diisi
                    $identitas = Datadiri::where('id_user', Auth::user()->id)->first();
                    if (!$identitas) {
                        return redirect()->route('petugas.identitas.create')->with('info', 'Silakan lengkapi data identitas Anda.');
                    }
                    return redirect()->route('petugas.dashboard');
                case 'admin_kecamatan':
                    return redirect()->route('admin_kecamatan.index');
                case 'admin_kabupaten':
                    return redirect()->route('admin_kabupaten.index');
                default:
                    return redirect()->route('login')->withErrors(['access' => 'Role tidak dikenali']);
            }
        }

        // Jika autentikasi gagal
        return redirect()->back()->withErrors(['identifier' => 'Password salah!'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
