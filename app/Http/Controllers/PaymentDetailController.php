<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Http\Response;

class PaymentDetailController extends Controller
{

    public function index()
    {
        return response()->json(PaymentDetail::all(), Response::HTTP_OK);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_payments' => 'required|integer',
            'typePay' => 'required|string|in:tien mat,momo,tai khoan ngan hang',
            'amountPay' => 'required|numeric|min:0'
        ]);

        $paymentDetail = PaymentDetail::create($validatedData);

        return response()->json($paymentDetail, Response::HTTP_CREATED);
    }

 
    public function show(string $id)
    {
        $paymentDetail = PaymentDetail::where('id_details', $id)->first();

        if (!$paymentDetail) {
            return response()->json(['message' => 'Chi tiết thanh toán không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($paymentDetail, Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $paymentDetail = PaymentDetail::where('id_details', $id)->first();

        if (!$paymentDetail) {
            return response()->json(['message' => 'Chi tiết thanh toán không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'id_payments' => 'sometimes|integer',
            'typePay' => 'sometimes|string|in:tien mat,momo,tai khoan ngan hang',
            'amountPay' => 'sometimes|numeric|min:0'
        ]);

        $paymentDetail->update($validatedData);

        return response()->json($paymentDetail, Response::HTTP_OK);
    }


    public function destroy(string $id)
    {
        $paymentDetail = PaymentDetail::where('id_details', $id)->first();

        if (!$paymentDetail) {
            return response()->json(['message' => 'Chi tiết thanh toán không tồn tại'], Response::HTTP_NOT_FOUND);
        }

        $paymentDetail->delete();

        return response()->json(['message' => 'Xóa chi tiết thanh toán thành công'], Response::HTTP_OK);
    }
}