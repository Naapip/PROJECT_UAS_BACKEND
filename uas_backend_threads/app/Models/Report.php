<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'thread_id', 'reason'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
