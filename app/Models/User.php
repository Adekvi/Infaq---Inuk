<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Master\Plotting;
use App\Models\Master\Setting;
use App\Models\Profil\Datadiri;
use App\Models\Pesan\WhatsappLog;
use App\Models\Role\Transaksi\Penerimaan;
use App\Models\Role\Transaksi\Pengirimaninfaq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Accessor untuk memformat role
    public function getFormattedRoleAttribute()
    {
        return match ($this->role) {
            'admin_kecamatan' => 'Admin Kecamatan',
            'admin_kabupaten' => 'Admin Kabupaten',
            'kolektor' => 'Kolektor',
            'superadmin' => 'Superadmin', // Opsional, jika ingin tetap menampilkan superadmin di tempat lain
            default => ucfirst($this->role), // Fallback untuk role lain
        };
    }

    public function datadiri()
    {
        return $this->hasMany(Datadiri::class, 'user_id');
    }

    public function whatsapp()
    {
        return $this->hasMany(WhatsappLog::class, 'id_user', 'id');
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class, 'id_setting', 'id');
    }

    public function plotting()
    {
        return $this->hasMany(Plotting::class, 'id_user', 'id');
    }

    public function terima()
    {
        return $this->hasMany(Penerimaan::class, 'id_user', 'id');
    }

    public function kirim()
    {
        return $this->hasMany(Pengirimaninfaq::class, 'id_user', 'id');
    }
}
