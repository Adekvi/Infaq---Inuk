<?php

namespace App\Models\Kode;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Verifyotp extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
