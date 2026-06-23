<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\ReportedReply;
use Illuminate\Http\Request;

class ReportedReplyController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validasi input alasan
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $reply = Reply::findOrFail($id);
        $userId = auth()->id();

        if ($reply->user_id === $userId) {
            return back()->with('error', 'Anda tidak bisa melaporkan komentar Anda sendiri!');
        }

        $alreadyReported = ReportedReply::where('reply_id', $reply->id)
                                        ->where('user_id', $userId)
                                        ->exists();

        if ($alreadyReported) {
            return back()->with('error', 'Anda sudah melaporkan komentar ini sebelumnya.');
        }

        // Tangkap isi reason dari form radio/dropdown
        ReportedReply::create([
            'reply_id' => $reply->id,
            'user_id' => $userId,
            'reason' => $request->reason
        ]);

        return back()->with('success', 'Komentar berhasil dilaporkan.');
    }
}