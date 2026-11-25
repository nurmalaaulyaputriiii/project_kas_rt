<?php

namespace App\Models;

use App\Models\Pembayaran;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Warga extends Authenticatable
{
    use Notifiable;

    protected $table = 'warga';

    protected $fillable = [
        'no_kk',
        'nama',
        'alamat',
        'no_hp',
        'status',
        'tanggal_daftar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'tanggal_daftar' => 'date',
    ];

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}