<?php

namespace App\Models\Master\Wilayah;

use App\Models\Master\Petugas\Db_petugas;
use App\Models\Master\Plotting;
use App\Models\Profil\Datadiri;
use Illuminate\Database\Eloquent\Model;

class Db_kelurahan extends Model
{
    protected $guarded = [];

    public function kecamatan()
    {
        return $this->belongsTo(Db_kecamatan::class, 'id_kecamatan', 'id');
    }

    public function datadiri()
    {
        return $this->hasMany(Datadiri::class, 'id_kelurahan', 'id');
    }

    public function plotting()
    {
        return $this->belongsToMany(Plotting::class, 'id_kelurahan', 'id');
    }

    // public function plotting()
    // {
    //     return $this->belongsToMany(Plotting::class, 'kelurahanplottings', 'kelurahan_id', 'plotting_id');
    // }
}
