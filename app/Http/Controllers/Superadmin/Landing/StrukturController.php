<?php

namespace App\Http\Controllers\Superadmin\Landing;

use App\Http\Controllers\Controller;
use App\Models\Landing\Struktur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $entries = $request->input('entries', 10);
        $page = $request->input('page', 1);

        // Input filter tahun mulai dan selesai
        $filterYearStart = $request->input('filter_year_start');
        $filterYearEnd = $request->input('filter_year_end');

        // Ambil tahun minimum dan maksimum dari database (start_date & manajemen_start_date, end_date & manajemen_end_date)
        $minStartDateYear = Struktur::selectRaw('MIN(YEAR(start_date)) as min_year')->value('min_year');
        $maxEndDateYear = Struktur::selectRaw('MAX(YEAR(end_date)) as max_year')->value('max_year');

        $minYearCandidates = array_filter([$minStartDateYear]);
        $maxYearCandidates = array_filter([$maxEndDateYear]);

        $minYear = $minYearCandidates ? min($minYearCandidates) : 2020;
        $maxYear = $maxYearCandidates ? max($maxYearCandidates) : (date('Y') + 1);

        // Query
        $query = Struktur::query();

        // Jika filter tahun mulai dan selesai ada, filter rentang waktu (masa khidmat)
        if ($filterYearStart && $filterYearEnd) {
            $query->where(function ($q) use ($filterYearStart, $filterYearEnd) {
                $q->where(function ($q2) use ($filterYearStart, $filterYearEnd) {
                    $q2->whereNotNull('start_date')
                        ->whereNotNull('end_date')
                        ->whereYear('start_date', '>=', $filterYearStart)
                        ->whereYear('end_date', '<=', $filterYearEnd);
                })
                    ->orWhere(function ($q3) use ($filterYearStart, $filterYearEnd) {
                        $q3->whereNotNull('manajemen_start_date')
                            ->whereNotNull('manajemen_end_date')
                            ->whereYear('manajemen_start_date', '>=', $filterYearStart)
                            ->whereYear('manajemen_end_date', '<=', $filterYearEnd);
                    });
            });
        }

        // Filter pencarian teks
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('masapengurus', 'LIKE', "%{$search}%")
                    ->orWhere('ketua', 'LIKE', "%{$search}%")
                    ->orWhere('wakilketua1', 'LIKE', "%{$search}%")
                    ->orWhere('wakilketua2', 'LIKE', "%{$search}%")
                    ->orWhere('wakilketua3', 'LIKE', "%{$search}%")
                    ->orWhere('sekretaris', 'LIKE', "%{$search}%")
                    ->orWhere('wakilsekretaris', 'LIKE', "%{$search}%")
                    ->orWhere('bendahara', 'LIKE', "%{$search}%")
                    ->orWhere('wakilbendahara', 'LIKE', "%{$search}%")
                    ->orWhere('penghimpunan', 'LIKE', "%{$search}%")
                    ->orWhere('pendistribusian', 'LIKE', "%{$search}%")
                    ->orWhere('keuangan', 'LIKE', "%{$search}%")
                    ->orWhere('humas', 'LIKE', "%{$search}%")
                    ->orWhere('alamat', 'LIKE', "%{$search}%")
                    ->orWhere('tanggal', 'LIKE', "%{$search}%")
                    ->orWhere('nomor', 'LIKE', "%{$search}%")
                    ->orWhere('judulsk', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $struktur = $query->orderBy('id', 'desc')->paginate($entries, ['*'], 'page', $page);
        $struktur->appends([
            'search' => $search,
            'entries' => $entries,
            'filter_year_start' => $filterYearStart,
            'filter_year_end' => $filterYearEnd,
        ]);

        $struktur->getCollection()->transform(function ($item) {
            $item->penghimpunan_array = $item->penghimpunan ? explode('|', $item->penghimpunan) : [];
            $item->pendistribusian_array = $item->pendistribusian ? explode('|', $item->pendistribusian) : [];
            $item->keuangan_array = $item->keuangan ? explode('|', $item->keuangan) : [];
            $item->humas_array = $item->humas ? explode('|', $item->humas) : [];
            return $item;
        });

        return view('superadmin.landing.struktur.index', compact(
            'struktur',
            'search',
            'entries',
            'filterYearStart',
            'filterYearEnd',
            'minYear',
            'maxYear'
        ));
    }

    public function updateStatus(Request $request)
    {
        $strukturId = $request->input('id');
        $newStatus = $request->has('status') ? 'Aktif' : 'Nonaktif';

        $struktur = Struktur::findOrFail($strukturId);
        $struktur->status = $newStatus;
        $struktur->save();

        return redirect()->back()->with('status', 'Status berhasil diubah!');
    }

    public function tambahdata()
    {
        $currentYear = Carbon::now()->year;
        $startYearRange = $currentYear;         // mulai dari tahun sekarang
        $endYearRange = $currentYear + 10;      // rentang 30 tahun ke depan

        // Bisa juga kirim nilai default kosong agar form tidak error
        $selectedStartYear = old('start_date') ?? '';
        $selectedEndYear = old('end_date') ?? '';
        $selectedManajemenStartYear = old('manajemen_start_date') ?? '';
        $selectedManajemenEndYear = old('manajemen_end_date') ?? '';

        return view('superadmin.landing.struktur.tambah', compact(
            'startYearRange',
            'endYearRange',
            'selectedStartYear',
            'selectedEndYear',
            'selectedManajemenStartYear',
            'selectedManajemenEndYear'
        ));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            // validasi tambahan sesuai kebutuhan
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {
            $originalName = $request->file('logo')->getClientOriginalName();
            $logo = $request->file('logo')->storeAs('landing/struktur/logo', $originalName, 'public');
        }

        // Format tanggal dari tahun inputan (format YYYY-01-01)
        $start_date = $request->start_year ? $request->start_year . '-01-01' : null;
        $end_date = $request->end_year ? $request->end_year . '-01-01' : null;

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'kalimat' => $request->kalimat,
            'logo' => $logo,
            'subjudul' => $request->subjudul,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
            'email' => $request->email,
            'alamatweb' => $request->alamatweb,
            'judulsk' => $request->judulsk,
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal, // tetap, jika ada
            'tentang' => $request->tentang, // tetap, jika ada
            'pengurus' => $request->pengurus,
            'judulpengurus' => $request->judulpengurus,
            'kabupaten' => $request->kabupaten,
            'masapengurus' => $request->masapengurus,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'ketua' => $request->ketua,
            'wakilketua1' => $request->wakilketua1,
            'wakilketua2' => $request->wakilketua2,
            'wakilketua3' => $request->wakilketua3,
            'sekretaris' => $request->sekretaris,
            'wakilsekretaris' => $request->wakilsekretaris,
            'bendahara' => $request->bendahara,
            'wakilbendahara' => $request->wakilbendahara,
            'penghimpunan' => implode('|', $request->penghimpunan),
            'pendistribusian' => implode('|', $request->pendistribusian),
            'keuangan' => implode('|', $request->keuangan),
            'humas' => implode('|', $request->humas),
            'status' => $request->status,
        ];

        Struktur::create($data);

        return redirect()->route('superadmin.landing.struktur');
    }

    public function editdata(Request $request, $id)
    {
        $struktur = Struktur::findOrFail($id);

        // Pisahkan kolom yang berbentuk string jadi array untuk form
        $struktur->penghimpunan = $struktur->penghimpunan ? explode('|', $struktur->penghimpunan) : [];
        $struktur->pendistribusian = $struktur->pendistribusian ? explode('|', $struktur->pendistribusian) : [];
        $struktur->keuangan = $struktur->keuangan ? explode('|', $struktur->keuangan) : [];
        $struktur->humas = $struktur->humas ? explode('|', $struktur->humas) : [];

        // Ambil tahun dari masing-masing kolom tanggal, atau fallback current year
        $years = [];

        if ($struktur->start_date) {
            $years[] = Carbon::parse($struktur->start_date)->year;
        }
        if ($struktur->end_date) {
            $years[] = Carbon::parse($struktur->end_date)->year;
        }

        $currentYear = Carbon::now()->year;

        // Jika data tahun kosong, pakai current year
        if (empty($years)) {
            $minYear = $currentYear;
            $maxYear = $currentYear + 10;
        } else {
            $minYear = min($years);
            $maxYear = max($years) + 5; // kasih buffer 5 tahun di atas max tahun data
            if ($maxYear < $currentYear) {
                $maxYear = $currentYear + 5; // minimal maxYear paling tidak 5 tahun ke depan
            }
        }

        return view('superadmin.landing.struktur.edit', compact(
            'struktur',
            'minYear',
            'maxYear'
        ));
    }

    public function edit(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'logo' => 'nullable|image|max:2048',
            // validasi lain sesuai kebutuhan
        ]);

        $struktur = Struktur::findOrFail($id);

        $logo = $struktur->logo; // Simpan dulu logo lama

        if ($request->hasFile('logo')) {
            // Hapus file logo lama jika ada (opsional)
            if ($logo && Storage::disk('public')->exists($logo)) {
                Storage::disk('public')->delete($logo);
            }

            $originalName = $request->file('logo')->getClientOriginalName();
            $logo = $request->file('logo')->storeAs('landing/struktur/logo', $originalName, 'public');
        }

        // Konversi tahun ke format tanggal 'YYYY-01-01'
        $start_date = $request->start_date ? $request->start_date . '-01-01' : null;
        $end_date = $request->end_date ? $request->end_date . '-01-01' : null;

        $data = [
            'tag' => $request->tag,
            'judul' => $request->judul,
            'kalimat' => $request->kalimat,
            'logo' => $logo,
            'subjudul' => $request->subjudul,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
            'email' => $request->email,
            'alamatweb' => $request->alamatweb,
            'judulsk' => $request->judulsk,
            'nomor' => $request->nomor,
            'tanggal' => $request->tanggal, // tetap, jika ada
            'tentang' => $request->tentang, // tetap, jika ada
            'pengurus' => $request->pengurus,
            'judulpengurus' => $request->judulpengurus,
            'kabupaten' => $request->kabupaten,
            'masapengurus' => $request->masapengurus,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'ketua' => $request->ketua,
            'wakilketua1' => $request->wakilketua1,
            'wakilketua2' => $request->wakilketua2,
            'wakilketua3' => $request->wakilketua3,
            'sekretaris' => $request->sekretaris,
            'wakilsekretaris' => $request->wakilsekretaris,
            'bendahara' => $request->bendahara,
            'wakilbendahara' => $request->wakilbendahara,
            'penghimpunan' => implode('|', $request->penghimpunan),
            'pendistribusian' => implode('|', $request->pendistribusian),
            'keuangan' => implode('|', $request->keuangan),
            'humas' => implode('|', $request->humas),
            'status' => $request->status,
        ];

        // dd($data);

        $struktur->update($data);

        return redirect()->route('superadmin.landing.struktur');
    }

    public function hapus($id)
    {
        Struktur::destroy($id);

        return redirect()->route('superadmin.landing.struktur');
    }
}
