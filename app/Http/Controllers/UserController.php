<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|max:100|unique:Users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:15',
            'role' => 'sometimes|in:User,Admin',
        ], [
            'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn email khác!',
            'email.email' => 'Email không hợp lệ!',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ!',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $validatedData = $validator->validated();
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

    // ========================================================================



    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return response()->json([
            'message' => 'Thêm thành công'
        ], Response::HTTP_OK);
    }


}