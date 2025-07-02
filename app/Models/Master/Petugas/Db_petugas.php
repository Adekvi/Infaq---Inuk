<?php

namespace App\Models\Master\Petugas;

use App\Models\Master\Wilayah\Db_kelurahan;
use Illuminate\Database\Eloquent\Model;

class Db_petugas extends Model
{
    protected $guarded = [];

    public function kelurahans()
    {
        return $this->belongsToMany(Db_kelurahan::class, 'db_kelurahan_petugas', 'id_petugas', 'id_kelurahan')
            ->withPivot('RW', 'RT')
            ->withTimestamps();
    }
}
