<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->with('thread.user')
            ->latest()
            ->get();

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|exists:threads,id'
        ]);

        $exists = Bookmark::where('user_id', Auth::id())
            ->where('thread_id', $request->thread_id)
            ->exists();

        if (!$exists) {
            Bookmark::create([
                'user_id'   => Auth::id(),
                'thread_id' => $request->thread_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bookmarked!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Already bookmarked.'
        ]);
    }
}
