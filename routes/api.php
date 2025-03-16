<?php

use App\Http\Controllers\BuildingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'API Laravel 12 đang hoạt động!']);
});

Route::apiResource('buildings', BuildingController::class); //LỆNH NÀY TƯƠNG ĐƯƠNG 5 LỆNH Ở DƯỚI, ÉO CẦN SỬA. THANH KIU

//==========================================================================
// Route::get('buildings', [BuildingController::class, 'index']);
// Route::post('buildings', [BuildingController::class, 'store']);
// Route::get('buildings/{id}', [BuildingController::class, 'show']);
// Route::put('buildings/{id}', [BuildingController::class, 'update']);
// Route::delete('buildings/{id}', [BuildingController::class, 'destroy']);
//==========================================================================