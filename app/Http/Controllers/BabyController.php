<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class BabyController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming baby + vaccination info
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'parent_name' => 'required|string|max:255',
            'bcg_vaccine' => 'nullable|boolean',
            'opv0_vaccine' => 'nullable|boolean',
            'hepb_vaccine' => 'nullable|boolean',
        ]);

        // Create the baby
        $baby = Baby::create([
            'name' => $validated['name'],
            'birth_date' => $validated['birth_date'],
            'parent_name' => $validated['parent_name'],
        ]);

        // Initial (at birth) vaccines
        $initialVaccines = [
            'BCG Vaccine' => [
                'status' => $request->bcg_vaccine ? 'completed' : 'missed',
                'age' => 'At birth'
            ],
            'OPV 0' => [
                'status' => $request->opv0_vaccine ? 'completed' : 'missed',
                'age' => 'At birth'
            ],
            'Hepatitis B' => [
                'status' => $request->hepb_vaccine ? 'completed' : 'missed',
                'age' => 'At birth'
            ],
        ];

        foreach ($initialVaccines as $name => $data) {
            Vaccination::create([
                'baby_id' => $baby->id,
                'vaccine_name' => $name,
                'dose' => '1st dose',
                'status' => $data['status'],
                'recommended_age' => $data['age'],
                'date_administered' => null,
                'administered_by' => null,
                'clinic_or_hospital' => null,
            ]);
        }

        // Other scheduled vaccines (default: pending)
        $otherVaccines = [
            ['name' => 'DTaP (Diphtheria, Tetanus, Pertussis)', 'age' => '2 months'],
            ['name' => 'Hib (Haemophilus influenzae type b)', 'age' => '2 months'],
            ['name' => 'Polio (IPV)', 'age' => '2 months'],
            ['name' => 'PCV13 (Pneumococcal)', 'age' => '2 months'],
            ['name' => 'Rotavirus', 'age' => '2 months'],
            ['name' => 'MMR (Measles, Mumps, Rubella)', 'age' => '12 months'],
        ];

        foreach ($otherVaccines as $vaccine) {
            Vaccination::create([
                'baby_id' => $baby->id,
                'vaccine_name' => $vaccine['name'],
                'dose' => '1st dose',
                'status' => 'pending',
                'recommended_age' => $vaccine['age'],
                'date_administered' => null,
                'administered_by' => null,
                'clinic_or_hospital' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Baby registered and vaccinations initialized.');
    }
    
}
