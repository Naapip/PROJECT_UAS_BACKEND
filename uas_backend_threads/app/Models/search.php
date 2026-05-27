<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class search extends Model
{
    // 1. Beritahu Laravel bahwa model ini menggunakan tabel bernama 'saved_searches'
    protected $table = 'saved_searches';

    // 2. Daftarkan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'user_id', 
        'keyword'
    ];

    /**
     * 3. Relasi: Setiap riwayat pencarian ini dicatat oleh seorang User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}