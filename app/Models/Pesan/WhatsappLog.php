<?php

namespace App\Models\Pesan;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
