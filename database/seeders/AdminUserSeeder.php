<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'super_admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'), // كلمة المرور
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
