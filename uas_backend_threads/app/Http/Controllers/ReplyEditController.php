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

    // 1. Ambil waktu pembuatan, pastikan di-parse sebagai objek Carbon
    $waktuPembuatan = \Carbon\Carbon::parse($reply->created_at);
    // 2. Ambil waktu sekarang secara presisi
    $waktuSekarang = \Carbon\Carbon::now();
    // 3. Hitung selisih waktu dalam MENIT secara absolut (mencegah nilai minus jika selisih detik)
    $selisihMenit = $waktuPembuatan->diffInMinutes($waktuSekarang, false);
    // [UNTUK DEBUG]: Jika kamu mau tahu isi angka menitnya, hapus tanda komen di bawah ini:
    // dd("Waktu Buat: " . $waktuPembuatan . " | Waktu Sekarang: " . $waktuSekarang . " | Selisih: " . $selisihMenit . " menit");
    // 4. VALIDASI LOGIKA: Jika selisihnya kurang dari 0 (eror sistem) ATAU lebih dari 5 menit, blokir!
    if ($selisihMenit < 0 || $selisihMenit > 5) {
        return redirect()->back()->with('error', 'Gagal! Batas waktu edit (maksimal 5 menit) telah habis. Selisih saat ini: ' . $selisihMenit . ' menit.');
    }

    // Jika lolos, update data ke database MySQL
    $reply->update([
        'content' => $request->content
    ]);

    return redirect('/thread/demo')->with('success', 'Komentar berhasil diperbarui!');
}
}