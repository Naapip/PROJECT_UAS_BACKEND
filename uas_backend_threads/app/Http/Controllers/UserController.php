<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'message' => 'User berhasil diupdate',
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'message' => 'User berhasil dihapus'
        ]);
    }
}