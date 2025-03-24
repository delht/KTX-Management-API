<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json(Payment::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_contracts' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:chua thanh toan,da thanh toan',
            'due_date' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $payment = Payment::create($validatedData);

        return response()->json($payment, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $payment = Payment::where('id_payments', $id)->first();

        if (!$payment) {
            return response()->json(['message' => 'Thanh toán không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($payment, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $payment = Payment::where('id_payments', $id)->first();

        if (!$payment) {
            return response()->json(['message' => 'Thanh toán không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'id_contracts' => 'sometimes|integer',
            'amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:chua thanh toan,da thanh toan',
            'due_date' => 'sometimes|date_format:Y-m-d H:i:s',
        ]);

        $payment->update($validatedData);

        return response()->json($payment, Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $payment = Payment::where('id_payments', $id)->first();

        if (!$payment) {
            return response()->json(['message' => 'Thanh toán không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $payment->delete();

        return response()->json(['message' => 'Xóa thanh toán thành công'], Response::HTTP_OK);
    }

    public function getPaymentInvoices($id_users)
    {
        // Lấy thông tin các hóa đơn thanh toán của người dùng
        $info = DB::table('Payments')
            ->join('Contracts', 'Payments.id_contracts', '=', 'Contracts.id_contracts')
            ->join('Rooms', 'Contracts.id_rooms', '=', 'Rooms.id_rooms')
            ->join('Users', 'Contracts.id_users', '=', 'Users.id_users')
            ->join('Payment_Details', 'Payments.id_payments', '=', 'Payment_Details.id_payments')
            ->select('Users.name', 'Rooms.number', 'Payments.amount', 'Payments.due_date', 'Payments.status', 'Payment_Details.amountPay')
            ->where('Users.id_users', $id_users)
            ->get();
        return response()->json($info);
    }
}