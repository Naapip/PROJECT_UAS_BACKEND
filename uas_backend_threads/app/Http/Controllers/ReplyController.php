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
        'thread_id' => 'required|exists:threads,id',
        'parent_reply_id' => 'nullable|exists:replies,id',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = null;

    // Jika user mengunggah file gambar/GIF
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('replies', 'public');
    }

    Reply::create([
        'thread_id' => $request->thread_id,
        'parent_reply_id' => $request->parent_reply_id,
        'user_id' => auth()->id(),
        'content' => $request->content,
        'image' => $imagePath,
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