<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::with('thread')->latest()->get();
        return view('bookmarks.index', compact('bookmarks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|exists:threads,id'
        ]);

        $exists = Bookmark::where('thread_id', $request->thread_id)->exists();

        if (!$exists) {
            Bookmark::create([
                'thread_id' => $request->thread_id
            ]);
            return response()->json(['success' => true, 'message' => 'Bookmarked!']);
        }

        return response()->json(['success' => false, 'message' => 'Already bookmarked.']);
    }
}
