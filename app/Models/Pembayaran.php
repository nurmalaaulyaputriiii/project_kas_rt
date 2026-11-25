<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'no_kk',
        'warga_id',
        'kas_bulanan_id',
        'pengurus_id',
        'tanggal_bayar',
        'jumlah',
        'metode_pembayaran',
        'jenis_pembayaran',
        'status',
        'bukti_transfer',
        'keterangan',
        'verified_by_role',
        'verified_by_name',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function kasBulanan()
    {
        return $this->belongsTo(KasBulanan::class);
    }

    public function pengurus()
    {
        return $this->belongsTo(Pengurus::class);
    }
}