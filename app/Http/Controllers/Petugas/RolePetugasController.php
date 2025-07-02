<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePetugasController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menyimpan status aktif di session jika login
            session(['petugas' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['petugas' => false]);
        }

        return view('petugas.dashboard.index');
    }
}
