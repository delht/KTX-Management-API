<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractService extends Model
{
    use HasFactory;
    protected $table = 'Contract_Service';
    protected $primaryKey = 'id_Cont_Ser'; // Đặt khóa chính là id_buildings
    public $incrementing = true; // Cho phép tự tăng
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_contracts', 'id_service'
    ];

}