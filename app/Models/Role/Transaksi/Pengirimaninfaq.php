<?php

namespace App\Models\Role\Transaksi;

use App\Models\Master\Plotting;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Pengirimaninfaq extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function penerimaans()
    {
        return $this->belongsToMany(Penerimaan::class, 'pengirimanpenerimaans', 'pengiriman_id', 'penerimaan_id');
    }
}
