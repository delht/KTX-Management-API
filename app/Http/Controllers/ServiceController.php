<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nameService' => 'required|string|max:30',
            'priceService' => 'required|numeric|min:0',
        ]);

        $service = Service::create($validatedData);

        return response()->json($service, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $service = Service::where('id_service', $id)->first();

        if (!$service) {
            return response()->json(['message' => 'Dịch vụ không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($service, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $service = Service::where('id_service', $id)->first();

        if (!$service) {
            return response()->json(['message' => 'Dịch vụ không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'nameService' => 'sometimes|string|max:30',
            'priceService' => 'sometimes|numeric|min:0',
        ]);

        $service->update($validatedData);

        return response()->json($service, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $service = Service::where('id_service', $id)->first();

        if (!$service) {
            return response()->json(['message' => 'Dịch vụ không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $service->delete();

        return response()->json(['message' => 'Xóa dịch vụ thành công'], Response::HTTP_OK);
    }
}