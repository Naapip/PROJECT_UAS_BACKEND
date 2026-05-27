<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Thread; 
use App\Models\SavedSearch;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $userResults = collect();
        $threadResults = collect();

        if (!empty($query)) {
            // 1. Cari berdasarkan Username atau Nama
            $userResults = User::where('name', 'LIKE', "%{$query}%")
                               ->where('id', '!=', Auth::id()) // jangan tampilkan diri sendiri
                               ->get();

            // 2. Cari berdasarkan isi konten Thread (Asumsi tabel threads milik Oscar punya kolom 'content')
            // Ganti 'Thread' sesuai dengan nama Model atau tabel yang dibuat Oscar nanti
            if (class_exists(\App\Models\Thread::class)) {
                $threadResults = Thread::where('content', 'LIKE', "%{$query}%")->latest()->get();
            }

            // 3. Opsional: Simpan ke riwayat pencarian
            SavedSearch::create([
                'user_id' => Auth::id(),
                'keyword' => $query
            ]);
        }

        // Ambil riwayat pencarian terakhir user
        $history = SavedSearch::where('user_id', Auth::id())->latest()->take(5)->get();

        return view('search-results', compact('userResults', $threadResults ? 'threadResults' : 'collect()', 'query', 'history'));
    }
}