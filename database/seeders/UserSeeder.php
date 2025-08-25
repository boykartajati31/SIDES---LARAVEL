<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Resident;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'id'    => 1,
            'name' => 'adminsidesa',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'approved',
            'role_id' => 1, // Assuming 1 is the ID for the admin
        ]);

        User::create([
            'id'    => 2,
            'name' => 'Penduduk!',
            'email' => 'penduduk1@gmail.com',
            'password' => bcrypt('password'),
            'status' => 'approved',
            'role_id' => 2, // Assuming 1 is the ID for the admin
        ]);

        Resident::create([
            'user_id'   => 2,
            'nik'   =>  '12345678910',
            'name'  =>  'AdamLevine',
            'gender'=>  'male',
            'birth_date'    => '2003-04-23',
            'birth_place'   => 'kerinci',
            'address'       => 'kerinci',
            'marital_status'    => 'single',
        ]);
    }
}
