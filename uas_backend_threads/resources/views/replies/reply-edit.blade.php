<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Komentar - Progres Naufal</title>
</head>
<body>

    <h2>Edit Komentar Kamu</h2>
    <p style="color: red;">*Catatan: Tombol simpan akan error otomatis jika sudah lewat 5 menit dari waktu pembuatan.</p>
    <hr>

    <!-- Menampilkan pesan error jika validasi 5 menit gagal -->
    @if(session('error'))
        <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
    @endif

    <form action="/reply/update/{{ $reply->id }}" method="POST">
        @csrf
        @method('PUT') <!-- Wajib di Laravel untuk proses Update/PUT -->
        
        <textarea name="content" rows="4" cols="50" required>{{ $reply->content }}</textarea><br><br>
        
        <button type="submit">Simpan Perubahan</button>
        <a href="/thread/demo">Batal</a>
    </form>

</body>
</html>