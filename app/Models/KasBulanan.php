<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasBulanan extends Model
{
    use HasFactory;

    protected $table = 'kas_bulanans';

    protected $fillable = [
        'bulan',
        'tahun',
        'nominal',
        'jatuh_tempo',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'nominal' => 'decimal:2',
        'jatuh_tempo' => 'date',
    ];
}