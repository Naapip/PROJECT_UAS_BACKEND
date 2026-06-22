<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike(Request $request)
    {
        $likeableId = $request->input('likeable_id');
        $likeableType = $request->input('likeable_type');

        $existingLike = Like::where('user_id', Auth::id())
                            ->where('likeable_id', $likeableId)
                            ->where('likeable_type', $likeableType)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'likeable_id' => $likeableId,
                'likeable_type' => $likeableType
            ]);
        }

        return back();
    }
}