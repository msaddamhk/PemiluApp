<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('saddam123');

        DB::table('users')->insert([
            'name' => 'Saddam',
            'email' => 'saddamhk567@gmail.com',
            'phone_number' => '081234567890',
            'photo' => 'default.png',
            'created_by' => 1,
            'updated_by' => 1,
            'level' => 'GENERAL',
            'is_active' => true,
            'password' => $password
        ]);
    }
}
