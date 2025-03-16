<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $table = 'Buildings';

    protected $primaryKey = 'id_buildings'; // Đặt khóa chính là id_buildings
    public $incrementing = true; // Cho phép tự tăng
    protected $keyType = 'int'; // Kiểu dữ liệu là số nguyên

    public $timestamps = false; //Mặc định post api trong lrv sẽ có thêm update_at, create_at, 
    //trong dtb dex có nên bỏ đi, ko thì lỗi lòi lon

    protected $fillable = [
        'nameBuild', 'location' // Không cần id_buildings vì nó tự tăng
    ];
}