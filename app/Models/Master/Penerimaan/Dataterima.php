<?php

namespace App\Models\Master\Penerimaan;

use App\Models\Role\Transaksi\Penerimaan;
use Illuminate\Database\Eloquent\Model;

class Dataterima extends Model
{
    protected $guarded = [];

    public function penerimaan()
    {
        return $this->hasMany(Penerimaan::class, 'id_terima', 'id');
    }
}
