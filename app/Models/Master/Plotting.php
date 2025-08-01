<?php

namespace App\Models\Master;

use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Profil\Datadiri;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\Role\Transaksi\Pengirimaninfaq;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Plotting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'Rt' => 'array', // Otomatis parse JSON ke array
        'Rw' => 'array', // Otomatis parse JSON ke array
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function datadiri()
    {
        return $this->belongsTo(Datadiri::class, 'id_datadiri', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Db_kecamatan::class, 'id_kecamatan', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Db_kelurahan::class, 'id_kelurahan', 'id');
    }

    // public function kelurahan()
    // {
    //     return $this->belongsToMany(Db_kelurahan::class, 'kelurahanplottings', 'plotting_id', 'kelurahan_id');
    // }

    public function terima()
    {
        return $this->hasMany(Penerimaan::class, 'id_plot', 'id');
    }

    public function kirim()
    {
        return $this->hasMany(Pengirimaninfaq::class, 'id_plot', 'id');
    }
}
