<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_buildings' => 'required|integer',
            'number' => 'required|integer',
            'type' => 'required|in:3 giuong,6 giuong,8 giuong',
            'current_occupancy' => 'sometimes|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $room = Room::create($validatedData);

        return response()->json($room, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $room = Room::where('id_rooms', $id)->first();

        if (!$room) {
            return response()->json(['message' => 'Phòng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($room, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $room = Room::where('id_rooms', $id)->first();

        if (!$room) {
            return response()->json(['message' => 'Phòng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'id_buildings' => 'sometimes|integer',
            'number' => 'sometimes|integer',
            'type' => 'sometimes|in:3 giuong,6 giuong,8 giuong',
            'current_occupancy' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $room->update($validatedData);

        return response()->json($room, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $room = Room::where('id_rooms', $id)->first();

        if (!$room) {
            return response()->json(['message' => 'Phòng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $room->delete();

        return response()->json(['message' => 'Xóa phòng thành công'], Response::HTTP_OK);
    }
}