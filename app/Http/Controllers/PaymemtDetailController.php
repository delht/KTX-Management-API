<?php

namespace App\Http\Controllers;

use App\Models\PaymemtDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymemtDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(PaymemtDetail::all(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymemtDetail $paymemtDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymemtDetail $paymemtDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymemtDetail $paymemtDetail)
    {
        //
    }
}