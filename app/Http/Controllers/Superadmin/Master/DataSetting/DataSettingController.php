<?php

namespace App\Http\Controllers\Superadmin\Master\DataSetting;

use App\Http\Controllers\Controller;
use App\Models\Master\Setting;
use Illuminate\Http\Request;

class DataSettingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Setting::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('namasetting', 'LIKE', "%{$search}%");
            });
        }

        $setting = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $setting->appends(['search' => $search, 'entries' => $entries]);

        return view('superadmin.master.data_setting.index', compact('setting', 'search', 'entries'));
    }

    public function tambahdata()
    {
        return view('superadmin.master.data_setting.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'namasetting' => 'required',
        ]);

        $data = [
            'namasetting' => $request->namasetting,
        ];

        Setting::create($data);

        return redirect()->route('superadmin.master.setting');
    }

    public function editdata(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        return view('superadmin.master.data_setting.edit', compact('setting'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'namasetting' => 'required',
        ]);

        $data = [
            'namasetting' => $request->namasetting,
        ];

        Setting::findOrFail($id)->update($data);

        return redirect()->route('superadmin.master.setting');
    }

    public function hapus($id)
    {
        Setting::destroy($id);

        return redirect()->route('superadmin.master.setting');
    }
}
