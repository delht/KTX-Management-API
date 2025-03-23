<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;

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

    // ====================================================================================

    public function getOccupants($id_rooms)
    {
        $count = DB::table('Contracts')
            ->where('id_rooms', $id_rooms)
            ->count();

        return response()->json($count);
    }

    public function getUsersInRoom($id_rooms)
    {
        $users = DB::table('Contracts')
            ->join('Users', 'Contracts.id_users', '=', 'Users.id_users')
            ->where('Contracts.id_rooms', $id_rooms)
            ->select('Users.id_users', 'Users.name', 'Users.email', 'Users.phone', 'Users.role')
            ->get();

        return response()->json($users);
    }

    public function searchRoom(Request $request)
    {
        $input = trim($request->input('gt')); // Lấy dữ liệu từ query string `q`

        if (!$input) {
            return response()->json(['error' => 'Vui lòng nhập từ khóa tìm kiếm'], 400);
        }

        $query = DB::table('Rooms')
            ->where('id_rooms', $input)
            ->orWhere('number', 'LIKE', '%' . $input . '%')
            ->orWhere('type', 'LIKE', '%' . $input . '%');

        $rooms = $query->select('id_rooms', 'id_buildings', 'number', 'type', 'current_occupancy', 'price')->get();

        if ($rooms->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy phòng'], 404);
        }

        return response()->json($rooms);
    }

    // ==================================================================================== lấy thông tin phòng theo tòa nhà và sô lượng phòng trống
    public function getRoomSummaryByLocation($id_buildings)
    {
        $totalRooms = DB::table('Buildings')
            ->where('id_buildings', $id_buildings)
            ->value('totalRooms');
        if (!$totalRooms) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], Response::HTTP_NOT_FOUND);
        }
        $rooms = DB::table('Rooms')
            ->where('id_buildings', $id_buildings)
            ->count();
        $emptyRooms = $totalRooms - $rooms;
        $roomDetails = Room::where('id_buildings', $id_buildings)
            ->get()
            ->map(function ($room) {
                $emptySlots = 8 - $room->current_occupancy;
                return [
                    'id_rooms' => $room->id_rooms,
                    'room_number' => $room->number,
                    'current_occupancy' => $room->current_occupancy,
                    'empty_slots' => $emptySlots,
                    'is_full' => $emptySlots <= 0
                ];
            });
        $statusMessage = $emptyRooms === 0 ? 'Tòa nhà đã đầy' : 'Tòa nhà còn trống';

        return response()->json([
            'total_rooms' => $totalRooms,
            'rooms_created' => $rooms,
            'empty_rooms' => $emptyRooms,
            'room_details' => $roomDetails,
            'status' => $statusMessage
        ]);
    }

    //=================================================================================================== // Lấy thông tin dịch vụ trong phòng
    public function getServicesInRoom($id_rooms)
    {
        $servicesInRoom = DB::table('rooms')
            ->join('contracts', 'rooms.id_rooms', '=', 'contracts.id_rooms')
            ->join('contract_service', 'contracts.id_contracts', '=', 'contract_service.id_contracts')
            ->join('service', 'contract_service.id_service', '=', 'service.id_service')
            ->where('rooms.id_rooms', $id_rooms)
            ->select(
                'rooms.number as room_number',
                'service.nameService as service_name',
                'service.priceService as service_price'
            )
            ->get();

        // Kiểm tra nếu không có dịch vụ nào trong phòng
        if ($servicesInRoom->isEmpty()) {
            return response()->json(['message' => 'Không có dịch vụ nào trong phòng này'], 404);
        }

        return response()->json([
            'id_rooms' => $id_rooms,
            'services' => $servicesInRoom
        ]);
    }


















}