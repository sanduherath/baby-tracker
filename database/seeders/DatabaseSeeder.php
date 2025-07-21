<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moh;
use App\Models\User;

class MohSeeder extends Seeder
{
    public function run()
    {
        $moh = Moh::create([
            'full_name' => 'Dr. John Doe',
            'registration_no' => 'MOH12345',
            'nic' => '123456789V',
            'date_of_birth' => '1980-01-15',
            'contact' => '0771234567',
            'moh_area' => 'Colombo',
            'hospital' => 'National Hospital',
            'email' => 'john.doe@moh.gov',
            'midwives_supervised' => 5,
            'phm_areas_covered' => 'Colombo 1, Colombo 2',
            'password' => 'moh123'
        ]);
         $this->call([
        MohSeeder::class,
        // Other seeders...
 ]);
        User::create([
            'name' => $moh->full_name,
            'email' => $moh->email,
            'password' => $moh->password,
            'role' => 'moh'
        ]);
    }

}
