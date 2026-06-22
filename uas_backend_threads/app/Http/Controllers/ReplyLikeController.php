<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\ReplyLike;
use Illuminate\Http\Request;

class ReplyLikeController extends Controller
{
    public function toggleLike($id)
    {
        $reply = Reply::findOrFail($id);
        $userId = auth()->id();

        // Cek apakah user sudah pernah like komentar ini
        $existingLike = ReplyLike::where('reply_id', $reply->id)
                                  ->where('user_id', $userId)
                                  ->first();

        if ($existingLike) {
            // Jika sudah ada, hapus (Unlike)
            $existingLike->delete();
            $liked = false;
        } else {
            // Jika belum ada, buat baru (Like)
            ReplyLike::create([
                'reply_id' => $reply->id,
                'user_id' => $userId
            ]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $reply->likes()->count()
        ]);
    }
}