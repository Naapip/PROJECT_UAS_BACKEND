<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'thread_id', 'parent_reply_id', 'content', 'image'];

    // Relasi ke User yang menulis balasan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi untuk mengambil anak-anak balasan (nested replies) di bawahnya
    public function childReplies()
    {
        return $this->hasMany(Reply::class, 'parent_reply_id')->with('user', 'childReplies');
    }
}