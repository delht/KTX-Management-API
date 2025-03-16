<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use Illuminate\Http\Response;

class BuildingController extends Controller
{
    /**
     * Lấy danh sách tất cả các tòa nhà.
     */
    public function index()
    {
        return response()->json(Building::all(), Response::HTTP_OK);
    }

    /**
     * Tạo một tòa nhà mới.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 'id_buildings' => 'required|integer|unique:Buildings,id_buildings',
            'nameBuild' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $building = Building::create($validatedData);

        return response()->json($building, Response::HTTP_CREATED);
    }

    /**
     * Hiển thị thông tin của một tòa nhà cụ thể.
     */
    public function show(string $id)
    {
        $building = Building::where('id_buildings', $id)->first();

        if (!$building) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($building, Response::HTTP_OK);
    }

    /**
     * Cập nhật thông tin của một tòa nhà.
     */
    public function update(Request $request, string $id)
    {
        $building = Building::where('id_buildings', $id)->first();

        if (!$building) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'nameBuild' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
        ]);

        $building->update($validatedData);

        return response()->json($building, Response::HTTP_OK);
    }

    /**
     * Xóa một tòa nhà khỏi hệ thống.
     */
    public function destroy(string $id)
    {
        $building = Building::where('id_buildings', $id)->first();

        if (!$building) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $building->delete();

        return response()->json(['message' => 'Xóa tòa nhà thành công'], Response::HTTP_OK);
    }
}