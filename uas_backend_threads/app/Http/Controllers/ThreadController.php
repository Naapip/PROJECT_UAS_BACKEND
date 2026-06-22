<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = \App\Models\Thread::with('user')->latest()->get();

        return view('threads.index', compact('threads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'community_or_topic' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/threads'), $fileName);
            $imagePath = 'uploads/threads/' . $fileName;
        } elseif ($request->filled('gif_url')) {
            $imagePath = $request->gif_url;
        }

        \App\Models\Thread::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'community_or_topic' => $request->community_or_topic,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('threads.index')->with('success', 'Thread berhasil diposting!');
    }

    public function show($id)
    {
        $thread = Thread::findOrFail($id);
        return view('threads.show', compact('thread'));
    }
}
