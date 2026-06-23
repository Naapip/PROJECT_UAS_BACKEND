<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.index', compact('users'));
    }

    public function show($userId)
    {
        $receiver = User::findOrFail($userId);
        $users = User::where('id', '!=', Auth::id())->get();

        $chats = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $userId)->where('receiver_id', Auth::id())->update(['is_read' => true]);

        return view('messages.show', compact('users', 'receiver', 'chats'));
    }

    public function store(Request $request, $userId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message,
        ]);

        return redirect()->back();
    }
}
