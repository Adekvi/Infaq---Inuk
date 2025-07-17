<?php

namespace App\Http\Controllers\Superadmin\Master\DataAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = User::whereIn('role', ['admin_kecamatan', 'admin_kabupaten'])
            ->orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                    ->orWhere('no_hp', 'LIKE', "%{$search}%");
            });
        }

        $useradmin = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $useradmin->appends(['search' => $search, 'entries' => $entries]);

        return view('superadmin.master.data_admin.index', compact('useradmin', 'search', 'entries'));
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


    // public function tambah(Request $request){
    //     $data = [

    //     ]
    // }
}
