<?php

namespace App\Models\Master\Wilayah;

use App\Models\Master\Petugas\Db_petugas;
use App\Models\Profil\Datadiri;
use Illuminate\Database\Eloquent\Model;

class Db_kelurahan extends Model
{
    protected $guarded = [];

    public function kecamatan()
    {
        return $this->belongsTo(Db_kecamatan::class, 'id_kecamatan', 'id');
    }

    public function petugas()
    {
        return $this->belongsToMany(Db_petugas::class, 'db_kelurahan_petugas', 'id_kelurahan', 'id_petugas')
            ->withPivot('RW', 'RT')
            ->withTimestamps();
    }

    public function datadiri()
    {
        return $this->hasMany(Datadiri::class, 'id_kelurahan', 'id');
    }
}
