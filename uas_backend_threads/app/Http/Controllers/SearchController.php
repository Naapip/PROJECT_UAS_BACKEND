<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Thread; 
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $userResults = collect();
        $threadResults = collect();

        if (!empty($query)) {
            $userResults = User::where('name', 'LIKE', "%{$query}%")
                               ->where('id', '!=', Auth::id()) 
                               ->get();

            if (class_exists(\App\Models\Thread::class)) {
                $threadResults = Thread::where('content', 'LIKE', "%{$query}%")->latest()->get();
            }

        }

        return view('search-results', compact('userResults', 'threadResults', 'query'));
    }
}