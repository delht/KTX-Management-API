<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContractController extends Controller
{
    public function index()
    {
        return response()->json(Contract::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_users' => 'required|integer',
            'id_rooms' => 'required|integer',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
        ]);

        $contract = Contract::create($validatedData);

        return response()->json($contract, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $contract = Contract::where('id_contracts', $id)->first();

        if (!$contract) {
            return response()->json(['message' => 'Hợp đồng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($contract, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $contract = Contract::where('id_contracts', $id)->first();

        if (!$contract) {
            return response()->json(['message' => 'Hợp đồng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'id_users' => 'sometimes|integer',
            'id_rooms' => 'sometimes|integer',
            'start_date' => 'sometimes|date_format:Y-m-d H:i:s',
            'end_date' => 'sometimes|date_format:Y-m-d H:i:s|after:start_date',
        ]);

        $contract->update($validatedData);

        return response()->json($contract, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $contract = Contract::where('id_contracts', $id)->first();

        if (!$contract) {
            return response()->json(['message' => 'Hợp đồng không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $contract->delete();

        return response()->json(['message' => 'Xóa hợp đồng thành công'], Response::HTTP_OK);
    }


    public function getContractByUser($id_users)
    {
        $id_users = DB::table('Users')
            ->join('Contracts', 'Users.id_users', '=', 'Contracts.id_users')
            ->join('Payments', 'Contracts.id_contracts', '=', 'Payments.id_contracts')
            ->join('Rooms', 'Contracts.id_rooms', '=', 'Rooms.id_rooms')
            ->select('Users.name', 'Users.phone', 'Rooms.number', 'Contracts.start_date', 'Contracts.end_date', 'Payments.amount', 'Payments.status', 'Payments.due_date')
            ->where('Users.id_users', $id_users)
            ->get();

        return response()->json($id_users);

    }

    public function GiaHanContract($id_contracts, $new_end_date)
    {
        $contract = DB::table('contracts')
            ->where('id_contracts', $id_contracts)
            ->update(['end_date' => $new_end_date]);
        if ($contract) {
            return response()->json(['message' => 'Hợp đồng đã được gia hạn thành công']);
        } else {
            return response()->json(['message' => 'Lỗi khi gia hạn hợp đồng'], 500);
        }
    }

}