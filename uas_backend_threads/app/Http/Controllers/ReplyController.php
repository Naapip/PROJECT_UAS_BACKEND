<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    // Fungsi untuk menyimpan data balasan
    public function store(Request $request)
    {
        // 1. Validasi input sederhana
        $request->validate([
            'content' => 'required|string',
            'thread_id' => 'required|integer',
            'parent_reply_id' => 'nullable|integer',
        ]);

        // 2. Simpan ke database MySQL
        // Catatan: Sementara user_id gua hardcode dulu jadi 1 untuk keperluan progres demo awal di localhost
        Reply::create([
            'user_id' => 1, 
            'thread_id' => $request->thread_id,
            'parent_reply_id' => $request->parent_reply_id,
            'content' => $request->content,
        ]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Balasan berhasil dikirim!');
    }
}