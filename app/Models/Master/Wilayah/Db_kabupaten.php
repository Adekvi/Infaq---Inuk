<?php

namespace App\Models\Master\Wilayah;

use Illuminate\Database\Eloquent\Model;

class Db_kabupaten extends Model
{
    protected $guarded = [];

    public function kecamatan()
    {
        return $this->hasMany(Db_kecamatan::class, 'id_kabupaten', 'id');
    }
}
