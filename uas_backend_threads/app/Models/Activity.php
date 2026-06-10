<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($type, $description, $userId = null) {
        return self::create([
            'user_id' => $userId ?? Auth::id() ?? 1, 
            'type' => $type,
            'description' => $description,
        ]);
    }
}