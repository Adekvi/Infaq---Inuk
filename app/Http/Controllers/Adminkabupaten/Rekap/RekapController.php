<?php

namespace App\Http\Controllers\AdminKabupaten\Rekap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index()
    {
        return view('admin_kabupaten.rekap.index');
    }
}
