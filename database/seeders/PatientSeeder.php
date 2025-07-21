<?php
namespace Database\Seeders;

use App\Models\Baby;
use App\Models\PregnantWoman;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run()
    {
        Baby::create(['name' => 'Emma Johnson', 'dob' => '2023-01-01']);
        Baby::create(['name' => 'Liam Garcia', 'dob' => '2023-02-01']);
        PregnantWoman::create(['name' => 'Sarah Johnson', 'dob' => '1990-05-15']);
        PregnantWoman::create(['name' => 'Maria Garcia', 'dob' => '1992-03-10']);
    }
}
