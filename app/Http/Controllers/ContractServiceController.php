<?php

namespace App\Http\Controllers;

use App\Models\ContractService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContractServiceController extends Controller
{
    public function index()
    {
        return response()->json(ContractService::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_contracts' => 'required|integer',
            'id_service' => 'required|integer',
        ]);

        $contractService = ContractService::create($validatedData);

        return response()->json($contractService, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $contractService = ContractService::where('id_Cont_Ser', $id)->first();

        if (!$contractService) {
            return response()->json(['message' => 'Dịch vụ hợp đồng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($contractService, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $contractService = ContractService::where('id_Cont_Ser', $id)->first();

        if (!$contractService) {
            return response()->json(['message' => 'Dịch vụ hợp đồng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'id_contracts' => 'sometimes|integer',
            'id_service' => 'sometimes|integer',
        ]);

        $contractService->update($validatedData);

        return response()->json($contractService, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $contractService = ContractService::where('id_Cont_Ser', $id)->first();

        if (!$contractService) {
            return response()->json(['message' => 'Dịch vụ hợp đồng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $contractService->delete();

        return response()->json(['message' => 'Xóa dịch vụ hợp đồng thành công'], Response::HTTP_OK);
    }
}