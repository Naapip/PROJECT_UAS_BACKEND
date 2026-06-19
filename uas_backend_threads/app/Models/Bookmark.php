<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['thread_id'];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }
}
