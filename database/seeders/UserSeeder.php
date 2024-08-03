<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Christian André Steffens',
            'email' => 'oficialsteffens@hotmail.com',
            'password' => Hash::make('123123123'),
            'phone' => '(51) 9 9930-4836',
            'birth_date' => '1998-09-21',
            'cpf' => '04668932051'
        ]);
    }
}
