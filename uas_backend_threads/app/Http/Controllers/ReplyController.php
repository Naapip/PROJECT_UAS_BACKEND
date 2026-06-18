<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    // Fungsi untuk menyimpan data balasan
    public function store(Request $request)
{
    $request->validate([
        'thread_id' => 'required|integer', 
        'content' => 'required|string',
    ]);

    Reply::create([
        'user_id' => auth()->id(),
        'thread_id' => $request->thread_id,
        'parent_reply_id' => $request->parent_reply_id, 
        'content' => $request->content,
    ]);

    return redirect()->route('threads.show', $request->thread_id)->with('success', 'Balasan berhasil dikirim!');
}

public function destroy($id)
{
    $reply = Reply::with('childReplies')->findOrFail($id);
    
    if ($reply->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'Gagal! Anda tidak punya akses untuk menghapus komentar ini.');
    }

    if ($reply->childReplies->count() > 0) {
        $reply->update([
            'content' => '[Komentar ini telah dihapus]'
        ]);
        $message = 'Komentar berhasil disamarkan karena memiliki balasan.';
    } else {

        $reply->delete();
        $message = 'Komentar berhasil dihapus permanen!';
    }

    return redirect()->back()->with('success', $message);
}
}