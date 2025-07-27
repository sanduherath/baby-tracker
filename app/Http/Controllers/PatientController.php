<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Baby;
use App\Models\PregnantWoman;
use App\Models\Midwife; // Add this line
use App\Models\User;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        // Fetch all babies and pregnant women for the authenticated midwife using midwife_name
        $babies = Baby::where('midwife_name', Auth::user()->name)->get();
        $pregnantWomen = PregnantWoman::where('midwife_name', Auth::user()->name)->get();

        return view('midwife.patient', compact('babies', 'pregnantWomen')); // Fixed case: 'Patient' to 'patient'
    }

    public function showBaby($id)
    {
        $baby = Baby::findOrFail($id);
        return view('baby.profile', compact('baby')); // Uncommented and fixed path
    }

    public function deleteBaby($id)
    {
        $baby = Baby::findOrFail($id);
        $baby->patient()->delete(); // Delete associated Patient record
        $baby->delete();
        return redirect()->route('midwife.patients')->with('success', 'Baby record deleted successfully.');
    }

    public function showPregnant($id)
    {
        $pregnantWoman = PregnantWoman::findOrFail($id);
        // return view('midwife.pregnant.profile', compact('pregnantWoman')); // Uncommented and fixed path
    }

    public function deletePregnant($id)
    {
        $pregnantWoman = PregnantWoman::findOrFail($id);
        $pregnantWoman->patient()->delete(); // Delete associated Patient record
        $pregnantWoman->delete();
        return redirect()->route('midwife.patients')->with('success', 'Pregnant woman record deleted successfully.');
    }

    public function storeBaby(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'baby_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'birth_weight' => 'required|numeric|min:0|max:10',
            'birth_hospital' => 'nullable|string|max:255',
            'delivery_type' => 'nullable|in:normal,cesarean,assisted',
            'gestational_age' => 'nullable|integer|min:20|max:45',
            'mother_name' => 'required|string|max:255',
            'mother_nic' => 'required|string|max:20|unique:users,email',
            'mother_contact' => 'required|string|max:15',
            'mother_email' => 'required|email|unique:users,email',
            'father_name' => 'nullable|string|max:255',
            'father_contact' => 'nullable|string|max:15',
            'address' => 'required|string',
            'grama_niladhari_division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'moh_area' => 'required|string|max:255',
            'birth_complications' => 'nullable|string',
            'congenital_conditions' => 'nullable|string',
            'bcg_vaccine' => 'boolean',
            'opv0_vaccine' => 'boolean',
            'hepb_vaccine' => 'boolean',
            'additional_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fetch valid midwife_id
        $midwifeId = Auth::user()->midwife ? Auth::user()->midwife->id : Midwife::where('name', Auth::user()->name)->value('id');
        if (!$midwifeId) {
            return redirect()->back()->withErrors(['midwife_id' => 'No valid midwife ID found.'])->withInput();
        }

        // Create Baby record
        $baby = Baby::create([
            'name' => $request->baby_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'birth_weight' => $request->birth_weight,
            'birth_hospital' => $request->birth_hospital,
            'delivery_type' => $request->delivery_type,
            'gestational_age' => $request->gestational_age,
            'mother_name' => $request->mother_name,
            'mother_nic' => $request->mother_nic,
            'mother_contact' => $request->mother_contact,
            'mother_email' => $request->mother_email,
            'father_name' => $request->father_name,
            'father_contact' => $request->father_contact,
            'address' => $request->address,
            'birth_complications' => $request->birth_complications,
            'congenital_conditions' => $request->congenital_conditions,
            'bcg_vaccine' => $request->bcg_vaccine ?? false,
            'opv0_vaccine' => $request->opv0_vaccine ?? false,
            'hepb_vaccine' => $request->hepb_vaccine ?? false,
            'additional_notes' => $request->additional_notes,
            'midwife_name' => Auth::user()->name,
            'midwife_id' => $midwifeId,
            'password' => Hash::make('user123'),
        ]);

        // Create Patient record with midwife_id
        $baby->patient()->create([
            'type' => 'baby',
            'district' => $request->district,
            'grama_niladhari_division' => $request->grama_niladhari_division,
            'moh_area' => $request->moh_area,
            'address' => $request->address,
            'midwife_id' => $midwifeId, // Add this line
        ]);

        // Create User record
        User::create([
            'name' => $request->mother_name,
            'email' => $request->mother_email,
            'password' => Hash::make('user123'),
            'role' => 'parent',
            'patientable_id' => $baby->id,
            'patientable_type' => Baby::class,
        ]);

        // Vaccination records
        $initialVaccines = [
            'BCG Vaccine' => ['status' => $request->bcg_vaccine ? 'completed' : 'missed', 'age' => 'At birth'],
            'OPV 0' => ['status' => $request->opv0_vaccine ? 'completed' : 'missed', 'age' => 'At birth'],
            'Hepatitis B' => ['status' => $request->hepb_vaccine ? 'completed' : 'missed', 'age' => 'At birth'],
        ];

        foreach ($initialVaccines as $name => $data) {
            Vaccination::create([
                'baby_id' => $baby->id,
                'vaccine_name' => $name,
                'dose' => '1st dose',
                'status' => $data['status'],
                'recommended_age' => $data['age'],
            ]);
        }

        $scheduledVaccines = [
            ['name' => 'DTaP (Diphtheria, Tetanus, Pertussis)', 'dose' => '1st dose', 'age' => '2 months'],
            ['name' => 'Hib (Haemophilus influenzae type b)', 'dose' => '1st dose', 'age' => '2 months'],
            ['name' => 'Polio (IPV)', 'dose' => '1st dose', 'age' => '2 months'],
            ['name' => 'PCV13 (Pneumococcal)', 'dose' => '1st dose', 'age' => '2 months'],
            ['name' => 'Rotavirus', 'dose' => '1st dose', 'age' => '2 months'],
            ['name' => 'DTaP (Diphtheria, Tetanus, Pertussis)', 'dose' => '2nd dose', 'age' => '4 months'],
            ['name' => 'Hib (Haemophilus influenzae type b)', 'dose' => '2nd dose', 'age' => '4 months'],
            ['name' => 'Polio (IPV)', 'dose' => '3rd dose', 'age' => '6 months'],
            ['name' => 'PCV13 (Pneumococcal)', 'dose' => '3rd dose', 'age' => '6 months'],
            ['name' => 'Rotavirus', 'dose' => '3rd dose', 'age' => '8 months'],
            ['name' => 'MMR (Measles, Mumps, Rubella)', 'dose' => '1st dose', 'age' => '12 months'],
        ];

        foreach ($scheduledVaccines as $vaccine) {
            Vaccination::create([
                'baby_id' => $baby->id,
                'vaccine_name' => $vaccine['name'],
                'dose' => $vaccine['dose'],
                'status' => 'pending',
                'recommended_age' => $vaccine['age'],
                'date_administered' => null,
                'administered_by' => null,
                'clinic_or_hospital' => null,
            ]);
        }

        return redirect()->route('midwife.addpatient')->with('success', 'Baby record and parent user account created successfully.');
    }

    public function showVaccinationRecord()
    {
        $baby = Baby::where('id', Auth::id())->firstOrFail();
        $vaccinations = $baby->vaccinations()->get();

        return view('baby.vaccination', compact('baby', 'vaccinations')); // Fixed case: 'Vaccination' to 'vaccination'
    }

    public function storePregnantWoman(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregnant_name' => 'required|string|max:255',
            'pregnant_nic' => 'required|string|max:20|unique:users,email',
            'pregnant_dob' => 'required|date',
            'pregnant_contact' => 'required|string|max:15',
            'pregnant_email' => 'required|email|unique:users,email',
            'pregnant_occupation' => 'nullable|string|max:255',
            'pregnant_husband_name' => 'nullable|string|max:255',
            'pregnant_husband_contact' => 'nullable|string|max:15',
            'pregnant_address' => 'required|string',
            'pregnant_gn_division' => 'required|string|max:255',
            'pregnant_district' => 'required|string|max:255',
            'pregnant_moh_area' => 'required|string|max:255',
            'lmp_date' => 'required|date',
            'edd_date' => 'required|date',
            'gravida' => 'required|integer|min:1',
            'para' => 'required|integer|min:0',
            'abortions' => 'nullable|integer|min:0',
            'living_children' => 'nullable|integer|min:0',
            'previous_complications' => 'nullable|string',
            'current_complications' => 'nullable|string',
            'diabetes' => 'nullable|boolean',
            'hypertension' => 'nullable|boolean',
            'asthma' => 'nullable|boolean',
            'heart_disease' => 'nullable|boolean',
            'thyroid' => 'nullable|boolean',
            'other_condition' => 'nullable|boolean',
            'other_medical_info' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Fetch valid midwife_id
        $midwifeId = Auth::user()->midwife ? Auth::user()->midwife->id : Midwife::where('name', Auth::user()->name)->value('id');
        if (!$midwifeId) {
            return redirect()->back()->withErrors(['midwife_id' => 'No valid midwife ID found.'])->withInput();
        }

        // Create PregnantWoman record
        $pregnantWoman = PregnantWoman::create([
            'name' => $request->pregnant_name,
            'nic' => $request->pregnant_nic,
            'dob' => $request->pregnant_dob,
            'contact' => $request->pregnant_contact,
            'email' => $request->pregnant_email,
            'occupation' => $request->pregnant_occupation,
            'husband_name' => $request->pregnant_husband_name,
            'husband_contact' => $request->pregnant_husband_contact,
            'address' => $request->pregnant_address,
            'grama_niladhari_division' => $request->pregnant_gn_division,
            'district' => $request->pregnant_district,
            'moh_area' => $request->pregnant_moh_area,
            'lmp_date' => $request->lmp_date,
            'edd_date' => $request->edd_date,
            'gravida' => $request->gravida,
            'para' => $request->para,
            'abortions' => $request->abortions,
            'living_children' => $request->living_children,
            'previous_complications' => $request->previous_complications,
            'current_complications' => $request->current_complications,
            'diabetes' => $request->diabetes ?? false,
            'hypertension' => $request->hypertension ?? false,
            'asthma' => $request->asthma ?? false,
            'heart_disease' => $request->heart_disease ?? false,
            'thyroid' => $request->thyroid ?? false,
            'other_condition' => $request->other_condition ?? false,
            'other_medical_info' => $request->other_medical_info,
            'midwife_name' => Auth::user()->name,
            'password' => Hash::make('user123'),
        ]);

        // Create Patient record with midwife_id
        $pregnantWoman->patient()->create([
            'type' => 'pregnant',
            'district' => $request->pregnant_district,
            'grama_niladhari_division' => $request->pregnant_gn_division,
            'moh_area' => $request->pregnant_moh_area,
            'address' => $request->pregnant_address,
            'midwife_id' => $midwifeId, // Add this line
        ]);

        // Create User record
        User::create([
            'name' => $request->pregnant_name,
            'email' => $request->pregnant_email,
            'password' => Hash::make('user123'),
            'role' => 'pregnant',
            'patientable_id' => $pregnantWoman->id,
            'patientable_type' => PregnantWoman::class,
        ]);

        return redirect()->route('midwife.addpatient')->with('success', 'Pregnant woman record and user account created successfully.');
    }

    public function show($id)
    {
        $baby = Baby::findOrFail($id);
        return view('baby.profile', compact('baby'));
    }
}
