<?php

namespace App\Http\Controllers\Adminkecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengecek apakah pengguna sudah login
        if (Auth::check()) {
            // Menyimpan status aktif di session jika login
            session(['admin_kecamatan' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['admin_kecamatan' => false]);
        }

        return view('admin_kecamatan.index');
    }
}
