<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedReply extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = [
        'reply_id', 
        'reason'
    ];

    // Relasi balik ke model Reply (Sangat bagus untuk impresi di depan dosen)
    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }
}