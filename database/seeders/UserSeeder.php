<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'adminsidesa',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'approved',
            'role_id' => 1, // Assuming 1 is the ID for the admin
        ]);
    }
}
