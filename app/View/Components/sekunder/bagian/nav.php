<?php

namespace App\View\Components\sekunder\bagian;

use App\Models\Role\Transaksi\Penerimaan;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class nav extends Component
{
    public $totalDonasi;
    public $jumlahDonatur;

    public function __construct()
    {
        // Ambil semua data penerimaan
        $penerimaan = Penerimaan::all();

        // Hitung total
        $this->totalDonasi = $penerimaan->sum('nominal');
        $this->jumlahDonatur = $penerimaan->count();
    }

    public function render(): View|Closure|string
    {
        return view('components.sekunder.bagian.nav', [
            'totalDonasi' => $this->totalDonasi,
            'jumlahDonatur' => $this->jumlahDonatur,
        ]);
    }
}
