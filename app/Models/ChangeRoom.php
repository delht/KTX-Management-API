<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeRoom extends Model
{
    use HasFactory;

    protected $table = 'Change_Rooms'; // Tạo liên kết tới bảng changeRooms

    protected $primaryKey = 'id_changeRooms'; // Đặt khóa chính là id_changeRooms
    public $incrementing = true; // Cho phép tự tăng
    protected $keyType = 'int'; // Kiểu dữ liệu là số nguyên
    public $timestamps = false; //Mặc định post api trong lrv sẽ có thêm update_at, create_at, 
    //trong dtb dex có nên bỏ đi, ko thì lỗi lòi lon

    protected $fillable = [
        'id_contract',
        'id_room',
        'id_roomOld',
        'dateChange',
        'reason',
        'status'
    ];


}
