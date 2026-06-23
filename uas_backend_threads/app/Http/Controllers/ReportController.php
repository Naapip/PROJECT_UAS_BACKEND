<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'thread_id' => 'required|exists:threads,id',
            'reason' => 'required|string|max:255',
        ]);

        $alreadyReported = Report::where('user_id', Auth::id())
            ->where('thread_id', $request->thread_id)
            ->exists();

        if ($alreadyReported) {
            return redirect()->back()->with('error', 'Anda sudah melaporkan postingan ini.');
        }

        Report::create([
            'user_id' => Auth::id(),
            'thread_id' => $request->thread_id,
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Postingan berhasil dilaporkan.');
    }
}
