<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymemtDetail extends Model
{
    use HasFactory;
    protected $table = 'Payment_details';
    protected $fillable = [
        'id_details', 'id_payments', 'typePay', 'amountPay'
    ];

}