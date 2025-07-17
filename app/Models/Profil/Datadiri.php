<?php

namespace App\Models\Profil;

use App\Models\db_kelurahan_petugas;
use App\Models\Master\Petugas\Db_petugas;
use App\Models\Master\Plotting;
use App\Models\Master\Setting;
use App\Models\Master\Wilayah\Db_kecamatan;
use App\Models\Master\Wilayah\Db_kelurahan;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Datadiri extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class, 'id_setting', 'id');
    }

    public function plotting()
    {
        return $this->hasMany(Plotting::class, 'id_datadiri', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Db_kecamatan::class, 'id_kecamatan', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Db_kelurahan::class, 'id_kelurahan', 'id');
    }
}
