<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;

class Struktur extends Model
{
    protected $fillable = [
        'id',
        'tag',
        'judul',
        'kalimat',
        'logo',
        'subjudul',
        'alamat',
        'no_telpon',
        'email',
        'alamatweb',
        'judulsk',
        'nomor',
        'tanggal',
        'tentang',
        'pengurus',
        'judulpengurus',
        'kabupaten',
        'masapengurus',
        'start_date',
        'end_date',
        'ketua',
        'wakilketua1',
        'wakilketua2',
        'wakilketua3',
        'sekretaris',
        'wakilsekretaris',
        'bendahara',
        'wakilbendahara',
        'penghimpunan',
        'pendistribusian',
        'keuangan',
        'humas',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        // Untuk array, gunakan cast 'array' jika simpan sebagai JSON, atau accessor custom
        // Tapi karena Anda pakai explode di controller, biarkan dulu
    ];

    // Optional: Accessor untuk array agar otomatis di model (pindah dari controller)
    public function getPenghimpunanArrayAttribute()
    {
        return $this->penghimpunan ? explode('|', $this->penghimpunan) : [];
    }
    public function getPendistribusianArrayAttribute()
    {
        return $this->pendistribusian ? explode('|', $this->pendistribusian) : [];
    }
    public function getKeuanganArrayAttribute()
    {
        return $this->keuangan ? explode('|', $this->keuangan) : [];
    }
    public function getHumasArrayAttribute()
    {
        return $this->humas ? explode('|', $this->humas) : [];
    }
    // Ulangi untuk pendistribusian_array, keuangan_array, humas_array
}
