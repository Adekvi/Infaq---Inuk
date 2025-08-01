<?php

namespace App\Http\Controllers\AdminKecamatan\Rekap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(Request $request)
    {
        return view('admin_kecamatan.rekap.kirim_data');
    }
}
