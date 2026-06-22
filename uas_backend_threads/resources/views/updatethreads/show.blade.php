<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <div class="container" style="max-width:500px">
        <h4 class="mb-3">Detail User</h4>
        <table class="table table-bordered table-sm">
            <tr>
                <th style="width:30%">ID</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td>{{ $user->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
        <div class="d-flex gap-2">
            <a href="{{ route('updatethreads.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <a href="{{ route('updatethreads.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>
</body>
</html>