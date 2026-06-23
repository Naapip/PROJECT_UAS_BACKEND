<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Follow;
use App\Models\User;

class RelationshipController extends Controller
{
    //fungsi untuk memproses Follow / Unfollow
    public function toggleFollow($id)
    {
        $UserId = auth()->id(); // Id user yg sedang Login

        if($UserId == $id){
            return redirect()->back(); //Untuk mencegah user mengikuti dirinya sendiri 
        }
        $exitingFollow = Follow::where('follower_id', $UserId)
            ->where('following_id', $id)
            ->first();
        
        if ($exitingFollow) {
            $exitingFollow->delete(); // Jika sudah mengikuti, maka akan di unfollow (Hapus data)
        } else {
            Follow::create([//jika belum mengikuti, maka akan di follow (Buat data baru)
                'follower_id' => $UserId,
                'following_id' => $id
            ]);
        }
        return redirect()->back(); 
    }
    public function index()
    {
        $user = auth()->user();
        
        $followers = User::whereIn('id', Follow::where('following_id', $user->id)->pluck('follower_id'))->get(); 
        $following = User::whereIn('id', Follow::where('follower_id', $user->id)->pluck('following_id'))->get(); 

        return view('search.connections', compact('followers', 'following'));
    }
}
