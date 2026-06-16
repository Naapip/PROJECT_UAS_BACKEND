<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        // Mengambil riwayat aktivitas pengguna yang sedang sesi, diurutkan dari yang terbaru
        $activities = Activity::where('user_id', Auth::id())
                              ->latest()
                              ->get();

        return view('activities.history-list', compact('activities'));
    }
}