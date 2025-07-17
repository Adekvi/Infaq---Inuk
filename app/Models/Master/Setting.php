<?php

namespace App\Models\Master;

use App\Models\Profil\Datadiri;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'id_setting', 'id');
    }

    public function datadiri()
    {
        return $this->hasmany(Datadiri::class, 'id_setting', 'id');
    }
}
