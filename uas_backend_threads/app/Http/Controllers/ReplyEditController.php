<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Faceades\Storage;

class ReplyEditController extends Controller
{
    public function edit($id)
    {
        $reply = Reply::findOrFail($id);

        if ($reply->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Gagal! Anda tidak berhak mengedit komentar ini.');
        }

        return view('replies.reply-edit', compact('reply'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    $reply = Reply::findOrFail($id);

    // PENGAMAN BACK-END
    if ($reply->user_id !== auth()->id()) {
        return redirect()->back()->with('error', 'Gagal! Anda tidak punya akses.');
    }

    // LOGIKA WAKTU 5 MENIT
    $waktuPembuatan = \Carbon\Carbon::parse($reply->created_at);
    $waktuSekarang = \Carbon\Carbon::now();
    $selisihMenit = $waktuPembuatan->diffInMinutes($waktuSekarang, false);

    if ($selisihMenit < 0 || $selisihMenit > 5) {
        return redirect()->back()->with('error', 'Gagal! Batas waktu edit telah habis.');
    }

    $updateData = [
        'content' => $request->content
    ];

    if ($request->hasFile('image')) {
        if ($reply->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($reply->image);
        }
        $updateData['image'] = $request->file('image')->store('replies', 'public');
    }

    $reply->update($updateData); 

    return redirect()->route('threads.show', $reply->thread_id)->with('success', 'Komentar berhasil diperbarui!');
}
}