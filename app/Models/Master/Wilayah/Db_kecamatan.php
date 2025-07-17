<?php

namespace App\Models\Master\Wilayah;

use App\Models\Profil\Datadiri;
use Illuminate\Database\Eloquent\Model;

class Db_kecamatan extends Model
{
    protected $guarded = [];

    public function kabupaten()
    {
        return $this->belongsTo(Db_kabupaten::class, 'id_kabupaten', 'id');
    }

    public function kelurahan()
    {
        return $this->hasMany(Db_kelurahan::class, 'id_kecamatan', 'id');
    }

    public function datadiri()
    {
        return $this->hasMany(Datadiri::class, 'id_kecamatan', 'id');
    }

    public function plotting()
    {
        return $this->hasMany(Db_kecamatan::class, 'id_kecamatan', 'id');
    }
}
