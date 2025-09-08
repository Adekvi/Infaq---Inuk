<?php

namespace App\Models\Role\Transaksi;

use App\Models\Master\Penerimaan\Dataterima;
use App\Models\Master\Plotting;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function plotting()
    {
        return $this->belongsTo(Plotting::class, 'id_plot', 'id');
    }

    public function dataterima()
    {
        return $this->belongsTo(Dataterima::class, 'id_terima', 'id');
    }

    public function kirim()
    {
        return $this->hasMany(Pengirimaninfaq::class, 'id_plot', 'id');
    }

    public function pengiriman()
    {
        return $this->belongsToMany(PengirimanInfaq::class, 'pengirimanpenerimaans', 'penerimaan_id', 'pengiriman_id');
    }
}
