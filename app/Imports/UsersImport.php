<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    private $count = 0;

    public function model(array $row)
    {
        

        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        $this->count++;

        return new User([
            'name' => $row['name'] ?? 'Unknown',
            'email' => $row['email'],
            'password' => Hash::make($row['phone']),
            'phone' => $row['phone'],
            'role' => $row['role'] ?? 'User',
        ]);
        
    }

    public function LaySoLuong()
    {
        return $this->count;
    }


    
}