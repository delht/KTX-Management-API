<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractServiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentDetailController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangeRoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;


Route::get('/test', function () {
    return response()->json(['message' => 'HELLOWORLD!!!']);
});

//==========================================================================
// Route::get('buildings', [BuildingController::class, 'index']);
// Route::post('buildings', [BuildingController::class, 'store']);
// Route::get('buildings/{id}', [BuildingController::class, 'show']);
// Route::put('buildings/{id}', [BuildingController::class, 'update']);
// Route::delete('buildings/{id}', [BuildingController::class, 'destroy']);
//==========================================================================

Route::apiResource('buildings', BuildingController::class); //LỆNH NÀY TƯƠNG ĐƯƠNG 5 LỆNH Ở TRÊN, ÉO CẦN SỬA. THANH KIU

Route::apiResource('contracts', ContractController::class);

Route::apiResource('contract-service', ContractServiceController::class);

Route::apiResource('payments', PaymentController::class);

Route::apiResource('payment-details', PaymentDetailController::class);

Route::apiResource('rooms', RoomController::class);

Route::apiResource('services', ServiceController::class);

Route::apiResource('users', UserController::class);

Route::apiResource('changerooms', ChangeRoomController::class);

// ============================================================================ Đăng nhập, tạo tài khoản

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-token-user', [AuthController::class, 'userInfo']);
});

Route::post('/users/import', [UserController::class, 'import']);

// ===================================================================================

Route::get('/room/{id}/sl-users', [RoomController::class, 'getOccupants']);
Route::get('/room/{id}/users', [RoomController::class, 'getUsersInRoom']);

// =================================================================================== Tìm kiếm

Route::get('/user/search', [UserController::class, 'searchUser']);
Route::get('/room/search', [RoomController::class, 'searchRoom']);

// =================================================================================== Lấy số lượng phòng trống
Route::get('/rooms/summary/{id_buildings}', [RoomController::class, 'getRoomSummaryByLocation']);
// =================================================================================== Lấy thông tin dịch vụ theo phòng
Route::get('/rooms/service/{id_rooms}', [RoomController::class, 'getServicesInRoom']);
// =================================================================================== Lấy thông tin người dùng đã thuê
Route::get('/users/{id_users}/rooms', [UserController::class, 'getRoom']);




