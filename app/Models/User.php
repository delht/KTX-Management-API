<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'Users';

    protected $primaryKey = 'id_users';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role'
    ];

    protected $hidden = [
        'password',
    ];
}