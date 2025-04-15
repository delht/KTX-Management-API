<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'Contracts';

    protected $primaryKey = 'id_contracts';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [

        'id_users',
        'id_rooms',
        'start_date',
        'end_date'
    ];
}