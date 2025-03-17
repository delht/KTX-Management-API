<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|unique:Users,name',
            'email' => 'nullable|email|max:100|unique:Users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:15',
            'role' => 'sometimes|in:User,Admin',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $user = User::where('id_users', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($user, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $user = User::where('id_users', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:50|unique:Users,name,' . $id . ',id_users',
            'email' => 'sometimes|email|max:100|unique:Users,email,' . $id . ',id_users',
            'password' => 'sometimes|string|min:6',
            'phone' => 'sometimes|string|max:15',
            'role' => 'sometimes|in:User,Admin',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json($user, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $user = User::where('id_users', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $user->delete();

        return response()->json(['message' => 'Xóa người dùng thành công'], Response::HTTP_OK);
    }
}