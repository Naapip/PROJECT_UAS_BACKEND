<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = [
        'user_id',
        'thread_id',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
}
