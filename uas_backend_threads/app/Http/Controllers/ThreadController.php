<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::with('user')->latest()->get();
        return view('threads.index', compact('threads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'community_or_topic' => 'nullable|string|max:100',
        ]);

        Thread::create([
            'user_id' => null,
            'content' => $request->content,
            'community_or_topic' => $request->community_or_topic,
        ]);

        return redirect()->back()->with('success', 'Thread berhasil diposting!');
    }
}
