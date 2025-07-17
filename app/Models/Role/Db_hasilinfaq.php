<?php

namespace App\Models\Role;

use App\Models\Master\Petugas\Db_petugas;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\Role\Petugas\Db_setorinfaq;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Db_hasilinfaq extends Model
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

    public function setor()
    {
        return $this->belongsTo(Db_setorinfaq::class, 'id_setor', 'id');
    }
}
