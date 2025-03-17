<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;
    protected $table = 'Payment_details';

    protected $primaryKey = 'id_details';
    public $incrementing = true; // Cho phép tự tăng
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'id_payments', 'typePay', 'amountPay'
    ];

}