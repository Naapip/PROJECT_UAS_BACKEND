<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    private function getUserId()
    {
        return Auth::id() ?? 1; 
    }

    public function index(Request $request)
    {
        $userId = $this->getUserId();

        $totalActivities = Activity::where('user_id', $userId)->count();

        $mostFrequent = Activity::where('user_id', $userId)
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->orderByDesc('total')
            ->first();

        $favoriteActivity = $mostFrequent ? ucwords(str_replace('_', ' ', $mostFrequent->type)) : 'Belum ada';

        $lastAction = Activity::where('user_id', $userId)->latest()->first();
        $lastActive = $lastAction ? $lastAction->created_at->diffForHumans() : 'Belum pernah';

        $query = Activity::where('user_id', $userId)->latest();

        if ($request->has('filter') && $request->filter !== 'all') {
            $query->where('type', $request->filter);
        }
        $activities = $query->get();

        $filterTypes = Activity::where('user_id', $userId)
            ->select('type')
            ->distinct()
            ->pluck('type');

        $currentFilter = $request->filter ?? 'all';

        return view('activities.history-list', compact(
            'activities', 
            'totalActivities', 
            'favoriteActivity', 
            'lastActive',
            'filterTypes',
            'currentFilter'
        ));
    }

    public function store(Request $request)
    {
        $request->validate(['description' => 'required|string|max:255']);
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
        return redirect('/activities')->with('success', 'Riwayat berhasil dibersihkan!');
    }
}