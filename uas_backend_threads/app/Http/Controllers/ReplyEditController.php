<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReplyEditController extends Controller
{
    // 1. Menampilkan halaman form edit
    public function edit($id)
    {
        $reply = Reply::findOrFail($id);
        return view('replies.reply-edit', compact('reply'));
    }

    // 2. Memproses update data ke database MySQL
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $reply = Reply::findOrFail($id);

        // LOGIKA UTAMA: Cek apakah waktu sekarang sudah lewat 5 menit dari waktu reply dibuat
        $waktuPembuatan = Carbon::parse($reply->created_at);
        if ($waktuPembuatan->diffInMinutes(Carbon::now()) > 5) {
            return redirect()->back()->with('error', 'Gagal! Batas waktu edit (maksimal 5 menit) telah habis.');
        }

        // Jika lolos dari validasi 5 menit, update datanya
        $reply->update([
            'content' => $request->content
        ]);

        return redirect('/thread/demo')->with('success', 'Komentar berhasil diperbarui!');
    }
}