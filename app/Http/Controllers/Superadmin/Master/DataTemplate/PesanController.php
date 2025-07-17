<?php

namespace App\Http\Controllers\Superadmin\Master\DataTemplate;

use App\Http\Controllers\Controller;
use App\Models\Master\Whatsapp\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        $query = Pesan::orderBy('id', 'asc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('namapesan', 'LIKE', "%{$search}%")
                    ->orWhere('template', 'LIKE', "%{$search}%");
            });
        }

        $pesan = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $pesan->appends(['search' => $search, 'entries' => $entries]);

        return view('superadmin.master.data_template.index', compact('pesan', 'search', 'entries'));
    }

    public function tambahdata()
    {
        return view('superadmin.master.data_template.tambah');
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'namapesan' => 'required',
            'template' => 'required',
        ]);

        $data = [
            'namapesan' => $request->namapesan,
            'template' => $request->template,
        ];

        Pesan::create($data);

        return redirect()->route('superadmin.master.pesan');
    }

    public function editdata(Request $request, $id)
    {
        $pesan = Pesan::findOrFail($id);

        return view('superadmin.master.data_template.edit', compact('pesan'));
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'namapesan' => 'required',
            'template' => 'required',
        ]);

        $data = [
            'namapesan' => $request->namapesan,
            'template' => $request->template,
        ];

        Pesan::findOrFail($id)->update($data);

        return redirect()->route('superadmin.master.pesan');
    }

    public function hapus($id)
    {
        Pesan::destroy($id);

        return redirect()->route('superadmin.master.pesan');
    }
}
