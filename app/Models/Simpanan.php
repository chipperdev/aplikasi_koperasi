<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis',      // contoh: 'sukarela', 'pokok', dll
        'tipe',       // 'rutin' atau 'non_rutin'
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    // Scope untuk simpanan sukarela rutin
    public function scopeRutin($query)
    {
        return $query->where('jenis', 'sukarela')->where('tipe', 'rutin');
    }

    // Scope untuk simpanan sukarela non rutin
    public function scopeNonRutin($query)
    {
        return $query->where('jenis', 'sukarela')->where('tipe', 'non_rutin');
    }
}
