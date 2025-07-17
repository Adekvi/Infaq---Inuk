<?php

namespace App\Http\Controllers\Kolektor;

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
            session(['kolektor' => true]);
        } else {
            // Menyimpan status tidak aktif di session jika tidak login
            session(['kolektor' => false]);
        }

        // Kembalikan ke view atau gunakan data
        return view('kolektor.dashboard.index');
    }
}
