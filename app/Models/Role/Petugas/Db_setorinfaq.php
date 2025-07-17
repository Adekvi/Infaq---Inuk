<?php

namespace App\Models\Role\Petugas;

use App\Models\db_kelurahan_petugas;
use App\Models\Master\Petugas\Db_petugas;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Role\Db_hasilinfaq;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Db_setorinfaq extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function petugas()
    {
        return $this->belongsTo(Db_petugas::class, 'id_petugas', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Db_kecamatan::class, 'id_kecamatan', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Db_kelurahan::class, 'id_kelurahan', 'id');
    }

    public function wilayahTugas()
    {
        return $this->hasMany(db_kelurahan_petugas::class, 'id_petugas', 'id_petugas'); // Relasi ke pivot
    }

    public function hasil()
    {
        return $this->hasMany(Db_hasilinfaq::class, 'id_setor', 'id');
    }
}
