<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReplyEditController extends Controller
{
    public function edit($id)
    {
        $reply = Reply::findOrFail($id);
        return view('replies.reply-edit', compact('reply'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    $reply = Reply::findOrFail($id);

    $waktuPembuatan = \Carbon\Carbon::parse($reply->created_at);
    $waktuSekarang = \Carbon\Carbon::now();
    $selisihMenit = $waktuPembuatan->diffInMinutes($waktuSekarang, false);

    if ($selisihMenit < 0 || $selisihMenit > 5) {
        return redirect()->back()->with('error', 'Gagal! Batas waktu edit (maksimal 5 menit) telah habis.');
    }

    $reply->update([
        'content' => $request->content
    ]);

    return redirect()->route('threads.show', $reply->thread_id)->with('success', 'Komentar berhasil diperbarui!');
}
}