<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ThreadController extends Controller
{
    public function index()
    {
        $threads = Thread::latest()->get();
        return view('threads.index', compact('threads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'community_or_topic' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gif_url' => 'nullable|url',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $imageName);
            $imagePath = 'uploads/' . $imageName;
        } elseif ($request->filled('gif_url')) {
            $imagePath = $request->gif_url;
        }

        Schema::disableForeignKeyConstraints();

        Thread::create([
            'user_id' => null,
            'content' => $request->content,
            'community_or_topic' => $request->community_or_topic,
            'image_path' => $imagePath,
        ]);

        Schema::enableForeignKeyConstraints();

        return redirect()->back()->with('success', 'Thread berhasil diposting!');
    }

    public function show($id)
    {
        $thread = Thread::findOrFail($id);
        return view('threads.show', compact('thread'));
    }
}
