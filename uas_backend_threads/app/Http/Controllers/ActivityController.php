<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    private function getUserId()
    {
        return Auth::id() ?? 1; 
    }

    public function index()
    {
        $activities = Activity::where('user_id', $this->getUserId())
                              ->latest()
                              ->get();

        // Mengarahkan ke file resources/views/activities/history-list.blade.php
        return view('activities.history-list', compact('activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255'
        ]);

        Activity::create([
            'user_id' => $this->getUserId(),
            'type' => 'manual_input',
            'description' => $request->description,
        ]);

        return redirect('/activities')->with('success', 'Aktivitas berhasil dicatat!');
    }

    public function clear()
    {
        Activity::where('user_id', $this->getUserId())->delete();

        return redirect('/activities')->with('success', 'Riwayat aktivitas berhasil dibersihkan!');
    }
}