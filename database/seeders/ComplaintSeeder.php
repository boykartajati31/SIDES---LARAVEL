<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Complaint;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Complaint::create([
            'resident_id'   =>  1,
            'title'         => 'smapah menumpuk Pk Lurah',
            'content'       =>  'Hai, Pk lurah sampah menumpuk ini',
        ]);
    }
}
