<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedReply extends Model
{
    protected $fillable = ['user_id', 'reply_id', 'reason'];
}