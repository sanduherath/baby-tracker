<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Baby;
use App\Models\ClinicRecord;
use App\Models\PregnantWoman;
use App\Models\ThriposhaDistribution;
use App\Models\Vaccination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;


class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->midwife) {
            Log::error('No authenticated user or midwife relationship found', [
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('login')->with('error', 'User not authenticated or midwife not found.');
        }

        $midwife = Auth::user()->midwife;
        $now = Carbon::now('Asia/Kolkata');
        $today = $now->toDateString();
        $selectedMonth = $request->query('month', $now->format('Y-m'));
        $calendarMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();

        Log::info('Fetching appointments at ' . $now->toDateTimeString(), [
            'midwife_id' => $midwife->id,
            'user_id' => Auth::user()->id,
        ]);

        // Update past-due appointments to "Missed"
        Appointment::where('midwife_id', $midwife->id)
            ->where('date', $today)
            ->where('status', 'scheduled')
            ->whereRaw("CONCAT(date, ' ', time) < ?", [$now->toDateTimeString()])
            ->update(['status' => 'missed']);

        // Today's Appointments
        $todayAppointments = Appointment::where('midwife_id', $midwife->id)
            ->whereDate('date', $today)
            ->whereRaw("CONCAT(date, ' ', time) >= ?", [$now->toDateTimeString()])
            ->with(['patient', 'clinicRecord'])
            ->orderBy('time', 'asc')
            ->get();

        // Include completed or missed appointments
        $todayAppointments = $todayAppointments->merge(
            Appointment::where('midwife_id', $midwife->id)
                ->whereDate('date', $today)
                ->whereIn('status', ['completed', 'missed'])
                ->with(['patient', 'clinicRecord'])
                ->orderBy('time', 'asc')
                ->get()
        )->unique('id')->sortBy('time');

        // Upcoming Appointments
        $upcomingAppointments = Appointment::where('midwife_id', $midwife->id)
            ->whereDate('date', '>', $today)
            ->whereDate('date', '<=', $now->copy()->addDays(7))
            ->with('patient')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // History Appointments
        $historyAppointments = Appointment::where('midwife_id', $midwife->id)
            ->where(function ($query) use ($today, $now) {
                $query->whereDate('date', '<', $today)
                    ->orWhere(function ($q) use ($today, $now) {
                        $q->whereDate('date', $today)
                            ->whereRaw("CONCAT(date, ' ', time) < ?", [$now->toDateTimeString()])
                            ->where('status', 'missed');
                    });
            })
            ->with('patient')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        // Calendar Appointments
        $calendarAppointments = Appointment::where('midwife_id', $midwife->id)
            ->whereBetween('date', [
                $calendarMonth->copy()->startOfMonth()->toDateString(),
                $calendarMonth->copy()->endOfMonth()->toDateString(),
            ])
            ->with('patient')
            ->get();

        // Fetch patients
        $babies = Baby::where('midwife_id', $midwife->id)->get();
        $pregnantWomen = PregnantWoman::where('midwife_id', $midwife->id)->get();

        Log::info('Patient counts:', [
            'babies' => $babies->count(),
            'pregnant_women' => $pregnantWomen->count(),
            'calendar_appointments' => $calendarAppointments->count(),
            'today_appointments' => $todayAppointments->count(),
            'upcoming_appointments' => $upcomingAppointments->count(),
            'history_appointments' => $historyAppointments->count(),
        ]);

        return view('midwife.Appointment', compact(
            'todayAppointments',
            'upcomingAppointments',
            'historyAppointments',
            'babies',
            'pregnantWomen',
            'calendarAppointments',
            'calendarMonth'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            Log::error('Unauthorized appointment creation attempt');
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $midwife = $user->midwife;

        $validated = $request->validate([
            'patient_type' => 'required|in:baby,pregnant',
            'patient_id' => 'required|integer',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'type' => 'required|in:vaccination,checkup,prenatal,other',
            'vaccination_type' => 'required_if:type,vaccination|nullable|string|in:bcg,opv0,hepatitis_b,dtap,hib,ipv,pcv13,rotavirus,mmr',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validated['patient_type'] === 'baby') {
            $patient = Baby::where('id', $validated['patient_id'])
                ->where('midwife_id', $midwife->id)
                ->first();
        } else {
            $patient = PregnantWoman::where('id', $validated['patient_id'])
                ->where('midwife_id', $midwife->id)
                ->first();
        }

        if (!$patient) {
            Log::error('Invalid patient for appointment', [
                'patient_id' => $validated['patient_id'],
                'patient_type' => $validated['patient_type'],
                'midwife_id' => $midwife->id,
            ]);
            return redirect()->back()->with('error', 'Selected patient is not under your supervision.');
        }

        $appointment = Appointment::create([
            'midwife_id' => $midwife->id,
            'patient_type' => $validated['patient_type'],
            'patient_id' => $validated['patient_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'type' => $validated['type'],
            'vaccination_type' => $validated['vaccination_type'],
            'notes' => $validated['notes'],
            'status' => 'scheduled',
            'read' => 0,
        ]);

        Log::info('Appointment created', [
            'appointment_id' => $appointment->id,
            'patient_type' => $validated['patient_type'],
            'patient_id' => $validated['patient_id'],
        ]);

        return redirect()->route('midwife.appointments')->with('success', 'Appointment created successfully.');
    }

    public function getNextVaccinationForBaby($babyId)
    {
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            Log::error('Unauthorized next vaccination fetch attempt', ['baby_id' => $babyId]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $midwife = $user->midwife;

        $baby = Baby::findOrFail($babyId);
        if ($baby->midwife_id !== $midwife->id) {
            Log::error('Unauthorized baby access for next vaccination', [
                'baby_id' => $babyId,
                'midwife_id' => $midwife->id,
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Define vaccination sequence and display names
        $vaccinationSequence = [
            'bcg' => 'BCG Vaccine',
            'opv0' => 'OPV 0',
            'hepatitis_b' => 'Hepatitis B',
            'dtap' => 'DTaP (Diphtheria, Tetanus, Pertussis)',
            'hib' => 'Hib (Haemophilus influenzae type b)',
            'ipv' => 'Polio (IPV)',
            'pcv13' => 'PCV13 (Pneumococcal)',
            'rotavirus' => 'Rotavirus',
            'mmr' => 'MMR (Measles, Mumps, Rubella)',
        ];

        // Fetch vaccination history for the baby
        $vaccinations = Vaccination::where('baby_id', $babyId)
            ->where('status', 'administered')
            ->pluck('vaccine_name')
            ->toArray();

        // Find the next vaccination
        $nextVaccination = null;
        $nextVaccinationDisplay = null;
        if (empty($vaccinations)) {
            // If no vaccinations administered, start with the first
            $nextVaccination = key(array_slice($vaccinationSequence, 0, 1));
            $nextVaccinationDisplay = $vaccinationSequence[$nextVaccination];
        } else {
            // Find the last administered vaccination
            $lastVaccination = null;
            foreach (array_reverse(array_keys($vaccinationSequence)) as $vaccine) {
                if (in_array($vaccine, $vaccinations)) {
                    $lastVaccination = $vaccine;
                    break;
                }
            }
            if ($lastVaccination) {
                $keys = array_keys($vaccinationSequence);
                $lastIndex = array_search($lastVaccination, $keys);
                if ($lastIndex !== false && $lastIndex < count($keys) - 1) {
                    $nextVaccination = $keys[$lastIndex + 1];
                    $nextVaccinationDisplay = $vaccinationSequence[$nextVaccination];
                }
            }
        }

        Log::info('Next vaccination fetched for baby', [
            'baby_id' => $babyId,
            'vaccinations' => $vaccinations,
            'next_vaccination' => $nextVaccination,
        ]);

        return response()->json([
            'nextVaccination' => $nextVaccination,
            'nextVaccinationDisplay' => $nextVaccinationDisplay,
        ]);
    }


    public function storeClinicRecord(Request $request, $appointmentId)
    {
        // Authenticate user and midwife
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            Log::error('Unauthorized clinic record save attempt', ['appointment_id' => $appointmentId]);
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $midwife = $user->midwife;

        // Fetch appointment
        try {
            $appointment = Appointment::findOrFail($appointmentId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Appointment not found', ['appointment_id' => $appointmentId]);
            return redirect()->back()->with('error', 'Appointment not found.');
        }

        // Verify midwife authorization
        if ($appointment->midwife_id !== $midwife->id) {
            Log::error('Unauthorized clinic record save attempt', [
                'appointment_id' => $appointmentId,
                'midwife_id' => $midwife->id
            ]);
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Get valid vaccination names for validation
        $validVaccinations = $appointment->type === 'vaccination' && $appointment->patient_type === 'baby'
            ? Vaccination::where('baby_id', $appointment->patient_id)
            ->whereIn('status', ['pending', 'missed'])
            ->pluck('vaccine_name')
            ->toArray()
            : [];

        // Define allowed vaccination names
        $allowedVaccinations = [
            'bcg',
            'opv0',
            'hepatitis_b',
            'dtap',
            'hib',
            'ipv',
            'pcv13',
            'rotavirus',
            'mmr',
            'Hepatitis B'
        ];

        // Validate request
        $validated = $request->validate([
            'weight' => 'nullable|numeric|min:0|max:99.99',
            'height' => 'nullable|numeric|min:0|max:99.99',
            'head_circumference' => 'nullable|numeric|min:0|max:99.99',
            'nutrition' => 'nullable|string|in:thriposha,vitamins',
            'thriposha_packets' => 'required_if:nutrition,thriposha|nullable|in:1,2',
            'vaccination_name' => [
                $appointment->type === 'vaccination' ? 'required' : 'nullable',
                'string',
                function ($attribute, $value, $fail) use ($validVaccinations, $allowedVaccinations, $appointment) {
                    if ($appointment->type === 'vaccination' && !in_array($value, $validVaccinations) && !in_array($value, $allowedVaccinations)) {
                        $fail('The selected vaccination is not valid or not pending/missed for this patient.');
                    }
                },
            ],
            'midwife_accommodations' => 'nullable|string|max:1000',
        ]);

        // Handle Thriposha distribution and stock update
        if ($appointment->type === 'checkup' && $validated['nutrition'] === 'thriposha' && !empty($validated['thriposha_packets'])) {
            $thriposhaType = $appointment->patient_type === 'baby' ? 'baby' : 'mother';
            $latestThriposhaRecord = ThriposhaDistribution::latest()->first();
            $currentBabyStock = $latestThriposhaRecord ? $latestThriposhaRecord->baby_thriposha_quantity : 0;
            $currentMotherStock = $latestThriposhaRecord ? $latestThriposhaRecord->mother_thriposha_quantity : 0;

            $packets = (int) $validated['thriposha_packets'];
            $currentStock = $thriposhaType === 'baby' ? $currentBabyStock : $currentMotherStock;
            if ($currentStock < $packets) {
                Log::warning('Insufficient Thriposha stock for distribution', [
                    'appointment_id' => $appointment->id,
                    'thriposha_type' => $thriposhaType,
                    'requested_packets' => $packets,
                    'current_stock' => $currentStock,
                ]);
                return redirect()->back()->with('error', "Insufficient $thriposhaType Thriposha stock. Only $currentStock packets available.");
            }

            $patient = $appointment->patient_type === 'baby'
                ? Baby::find($appointment->patient_id)
                : PregnantWoman::find($appointment->patient_id);
            $recipientName = $patient ? $patient->name : 'Unknown';
            $recipientId = $patient ? $appointment->patient_id : null;

            $newBabyStock = $thriposhaType === 'baby' ? $currentBabyStock - $packets : $currentBabyStock;
            $newMotherStock = $thriposhaType === 'mother' ? $currentMotherStock - $packets : $currentMotherStock;

            ThriposhaDistribution::create([
                'date' => Carbon::now('Asia/Kolkata'),
                'type' => $thriposhaType,
                'quantity' => $packets,
                'transaction_type' => 'distribution',
                'recipient' => $recipientName,
                'recipient_id' => $recipientId,
                'notes' => $validated['midwife_accommodations'] ?? null,
                'baby_thriposha_quantity' => $newBabyStock,
                'mother_thriposha_quantity' => $newMotherStock,
            ]);

            Log::info('Thriposha distribution recorded', [
                'appointment_id' => $appointment->id,
                'thriposha_type' => $thriposhaType,
                'quantity' => $packets,
                'new_baby_stock' => $newBabyStock,
                'new_mother_stock' => $newMotherStock,
            ]);
        }

        // Create clinic record
        $clinicRecord = ClinicRecord::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'patient_type' => $appointment->patient_type,
            'weight' => $validated['weight'],
            'height' => $validated['height'],
            'head_circumference' => $appointment->type === 'checkup' ? $validated['head_circumference'] : null,
            'nutrition' => $appointment->type === 'checkup' ? $validated['nutrition'] : null,
            'thriposha_packets' => $appointment->type === 'checkup' && $validated['nutrition'] === 'thriposha' ? $validated['thriposha_packets'] : null,
            'vaccination_name' => $appointment->type === 'vaccination' ? $validated['vaccination_name'] : null,
            'midwife_accommodations' => $validated['midwife_accommodations'],
        ]);

        // Update appointment status
        $appointment->update(['status' => 'completed']);

        // Update baby record if patient_type is baby
        if ($appointment->patient_type === 'baby') {
            $baby = Baby::find($appointment->patient_id);

            if ($baby) {
                // Update weight, height, and head circumference
                $baby->current_weight = $validated['weight'] ?? $baby->current_weight;
                $baby->current_height = $validated['height'] ?? $baby->current_height;
                $baby->head_circumference = $validated['head_circumference'] ?? $baby->head_circumference;

                // Calculate BMI (weight in kg / (height in meters)^2)
                if ($validated['weight'] && $validated['height']) {
                    $heightInMeters = $validated['height'] / 100; // Convert cm to meters
                    $bmi = $validated['weight'] / ($heightInMeters * $heightInMeters);
                    $baby->bmi = round($bmi, 2); // Round to 2 decimal places
                }

                $baby->save();

                Log::info('Baby record updated with clinic data', [
                    'baby_id' => $baby->id,
                    'weight' => $baby->current_weight,
                    'height' => $baby->current_height,
                    'head_circumference' => $baby->head_circumference,
                    'bmi' => $baby->bmi,
                ]);
            }
        }

        // Update vaccination record
        if ($appointment->type === 'vaccination' && !empty($validated['vaccination_name']) && $appointment->patient_type === 'baby') {
            $vaccineName = $validated['vaccination_name'];
            Log::info('Attempting to update vaccination record', [
                'appointment_id' => $appointment->id,
                'baby_id' => $appointment->patient_id,
                'vaccine_name' => $vaccineName,
            ]);

            $vaccination = Vaccination::where('baby_id', $appointment->patient_id)
                ->where('vaccine_name', $vaccineName)
                ->whereIn('status', ['pending', 'missed'])
                ->orderByRaw("CASE dose
                WHEN '1st' THEN 1
                WHEN '1' THEN 1
                WHEN '2nd' THEN 2
                WHEN '2' THEN 2
                WHEN '3rd' THEN 3
                WHEN '3' THEN 3
                ELSE 999 END")
                ->first();

            if ($vaccination) {
                $vaccination->update([
                    'status' => 'completed',
                    'date_administered' => Carbon::now('Asia/Kolkata')->toDateString(),
                    'administered_by' => $midwife->id,
                    'clinic_or_hospital' => 'Clinic',
                ]);

                Log::info('Vaccination record updated', [
                    'vaccination_id' => $vaccination->id,
                    'baby_id' => $appointment->patient_id,
                    'vaccine_name' => $vaccineName,
                    'dose' => $vaccination->dose,
                    'status' => 'completed',
                ]);
            } else {
                Log::warning('No eligible vaccination record found to update', [
                    'baby_id' => $appointment->patient_id,
                    'vaccine_name' => $vaccineName,
                    'valid_statuses' => ['pending', 'missed'],
                ]);
                return redirect()->route('midwife.appointments')->with('error', 'No pending or missed vaccination record found for ' . $vaccineName);
            }
        } else {
            Log::info('No vaccination update required', [
                'appointment_id' => $appointment->id,
                'type' => $appointment->type,
                'patient_type' => $appointment->patient_type,
                'vaccination_name' => $validated['vaccination_name'] ?? null,
            ]);
        }

        Log::info('Clinic record saved and appointment completed', [
            'clinic_record_id' => $clinicRecord->id,
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'vaccination_name' => $validated['vaccination_name'] ?? null,
        ]);

        return redirect()->route('midwife.appointments')->with('success', 'Clinic record saved and appointment marked as completed.');
    }
    public function updateStatus(Request $request, $appointmentId)
    {
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $midwife = $user->midwife;

        $appointment = Appointment::findOrFail($appointmentId);
        if ($appointment->midwife_id !== $midwife->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:completed,missed',
        ]);

        $appointment->update(['status' => $validated['status']]);

        Log::info('Appointment status updated', [
            'appointment_id' => $appointment->id,
            'new_status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'appointment' => [
                'id' => $appointment->id,
                'status' => $appointment->status,
                'status_ucfirst' => ucfirst($appointment->status),
            ],
        ]);
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $midwife = $user->midwife;

        $query = $request->query('query');
        $babies = Baby::where('midwife_id', $midwife->id)->get()->keyBy('id');
        $pregnantWomen = PregnantWoman::where('midwife_id', $midwife->id)->get()->keyBy('id');

        $todayAppointments = Appointment::where('midwife_id', $midwife->id)
            ->whereDate('date', Carbon::today('Asia/Kolkata'))
            ->where(function ($q) use ($query, $babies, $pregnantWomen) {
                $q->where('type', 'like', "%$query%")
                    ->orWhere('vaccination_type', 'like', "%$query%")
                    ->orWhereHas('patient', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->orWhere(function ($q) use ($query, $babies) {
                        $q->where('patient_type', 'baby')
                            ->whereIn('patient_id', $babies->where('name', 'like', "%$query%")->pluck('id'));
                    })
                    ->orWhere(function ($q) use ($query, $pregnantWomen) {
                        $q->where('patient_type', 'pregnant')
                            ->whereIn('patient_id', $pregnantWomen->where('name', 'like', "%$query%")->pluck('id'));
                    });
            })
            ->with(['patient', 'clinicRecord'])
            ->get()
            ->map(function ($appointment) use ($babies, $pregnantWomen) {
                $patient_name = null;
                $patient_age = null;

                if ($appointment->patient) {
                    $patient_name = $appointment->patient->name . ' (' . ($appointment->patient_type === 'baby' ? 'B' : 'PW') . '-' . $appointment->patient_id . ')';
                    $patient_age = $appointment->patient_type === 'baby'
                        ? round(Carbon::parse($appointment->patient->birth_date)->floatDiffInMonths(Carbon::now('Asia/Kolkata')), 1) . ' months'
                        : round(Carbon::parse($appointment->patient->dob)->floatDiffInYears(Carbon::now('Asia/Kolkata')), 1) . ' years';
                } elseif ($appointment->patient_type === 'baby' && isset($babies[$appointment->patient_id])) {
                    $baby = $babies[$appointment->patient_id];
                    $patient_name = $baby->name . ' (B-' . $appointment->patient_id . ')';
                    $patient_age = round(Carbon::parse($baby->birth_date)->floatDiffInMonths(Carbon::now('Asia/Kolkata')), 1) . ' months';
                } elseif ($appointment->patient_type === 'pregnant' && isset($pregnantWomen[$appointment->patient_id])) {
                    $pw = $pregnantWomen[$appointment->patient_id];
                    $patient_name = $pw->name . ' (PW-' . $appointment->patient_id . ')';
                    $patient_age = round(Carbon::parse($pw->dob)->floatDiffInYears(Carbon::now('Asia/Kolkata')), 1) . ' years';
                }

                return [
                    'id' => $appointment->id,
                    'time_formatted' => Carbon::parse($appointment->time)->format('h:i A'),
                    'patient_name' => $patient_name,
                    'patient_age' => $patient_age,
                    'patient_type_ucfirst' => ucfirst($appointment->patient_type),
                    'purpose' => ucfirst($appointment->type) . ($appointment->type === 'vaccination' && $appointment->vaccination_type ? " ({$appointment->vaccination_type})" : ''),
                    'status' => $appointment->status,
                    'status_ucfirst' => ucfirst($appointment->status),
                    'patient_type' => $appointment->patient_type,
                    'patient_id' => $appointment->patient_id,
                    'has_clinic_record' => $appointment->clinicRecord !== null,
                ];
            });

        $upcomingAppointments = Appointment::where('midwife_id', $midwife->id)
            ->whereDate('date', '>', Carbon::today('Asia/Kolkata'))
            ->whereDate('date', '<=', Carbon::today('Asia/Kolkata')->addDays(7))
            ->where(function ($q) use ($query, $babies, $pregnantWomen) {
                $q->where('type', 'like', "%$query%")
                    ->orWhere('vaccination_type', 'like', "%$query%")
                    ->orWhereHas('patient', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->orWhere(function ($q) use ($query, $babies) {
                        $q->where('patient_type', 'baby')
                            ->whereIn('patient_id', $babies->where('name', 'like', "%$query%")->pluck('id'));
                    })
                    ->orWhere(function ($q) use ($query, $pregnantWomen) {
                        $q->where('patient_type', 'pregnant')
                            ->whereIn('patient_id', $pregnantWomen->where('name', 'like', "%$query%")->pluck('id'));
                    });
            })
            ->with(['patient', 'clinicRecord'])
            ->get()
            ->map(function ($appointment) use ($babies, $pregnantWomen) {
                $patient_name = null;
                $patient_age = null;

                if ($appointment->patient) {
                    $patient_name = $appointment->patient->name . ' (' . ($appointment->patient_type === 'baby' ? 'B' : 'PW') . '-' . $appointment->patient_id . ')';
                    $patient_age = $appointment->patient_type === 'baby'
                        ? round(Carbon::parse($appointment->patient->birth_date)->floatDiffInMonths(Carbon::now('Asia/Kolkata')), 1) . ' months'
                        : round(Carbon::parse($appointment->patient->dob)->floatDiffInYears(Carbon::now('Asia/Kolkata')), 1) . ' years';
                } elseif ($appointment->patient_type === 'baby' && isset($babies[$appointment->patient_id])) {
                    $baby = $babies[$appointment->patient_id];
                    $patient_name = $baby->name . ' (B-' . $appointment->patient_id . ')';
                    $patient_age = round(Carbon::parse($baby->birth_date)->floatDiffInMonths(Carbon::now('Asia/Kolkata')), 1) . ' months';
                } elseif ($appointment->patient_type === 'pregnant' && isset($pregnantWomen[$appointment->patient_id])) {
                    $pw = $pregnantWomen[$appointment->patient_id];
                    $patient_name = $pw->name . ' (PW-' . $appointment->patient_id . ')';
                    $patient_age = round(Carbon::parse($pw->dob)->floatDiffInYears(Carbon::now('Asia/Kolkata')), 1) . ' years';
                }

                return [
                    'id' => $appointment->id,
                    'date_time_formatted' => Carbon::parse($appointment->date)->format('M d, h:i A'),
                    'patient_name' => $patient_name,
                    'patient_age' => $patient_age,
                    'patient_type_ucfirst' => ucfirst($appointment->patient_type),
                    'purpose' => ucfirst($appointment->type) . ($appointment->type === 'vaccination' && $appointment->vaccination_type ? " ({$appointment->vaccination_type})" : ''),
                    'status' => $appointment->status,
                    'status_ucfirst' => ucfirst($appointment->status),
                    'patient_type' => $appointment->patient_type,
                    'patient_id' => $appointment->patient_id,
                    'has_clinic_record' => $appointment->clinicRecord !== null,
                ];
            });

        return response()->json([
            'todayAppointments' => $todayAppointments,
            'upcomingAppointments' => $upcomingAppointments,
        ]);
    }

    public function getCalendarAppointments(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $midwife = $user->midwife;

        $month = $request->query('month');
        if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = Carbon::now('Asia/Kolkata')->format('Y-m');
        }

        $calendarMonth = Carbon::createFromFormat('Y-m', $month, 'Asia/Kolkata')->startOfMonth();
        $startOfMonth = $calendarMonth->copy()->startOfMonth();
        $endOfMonth = $calendarMonth->copy()->endOfMonth();
        $startOfCalendar = $startOfMonth->copy()->startOfWeek();
        $endOfCalendar = $endOfMonth->copy()->endOfWeek();

        $babies = Baby::where('midwife_id', $midwife->id)->get()->keyBy('id');

        $appointments = Appointment::where('midwife_id', $midwife->id)
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->with(['patient', 'clinicRecord'])
            ->get()
            ->groupBy(function ($appointment) {
                return Carbon::parse($appointment->date)->toDateString();
            });

        $calendarDays = [];
        $currentDay = $startOfCalendar->copy();
        while ($currentDay <= $endOfCalendar) {
            $dateStr = $currentDay->toDateString();
            $calendarDays[$dateStr] = [
                'day' => $currentDay->day,
                'isToday' => $currentDay->isToday(),
                'isCurrentMonth' => $currentDay->month === $calendarMonth->month,
                'appointments' => isset($appointments[$dateStr]) ? $appointments[$dateStr]->map(function ($appointment) use ($babies) {
                    $patientName = $appointment->patient
                        ? "{$appointment->patient->name} (" . ($appointment->patient_type === 'baby' ? 'B' : 'PW') . "-{$appointment->patient_id})"
                        : ($appointment->patient_type === 'baby'
                            ? (isset($babies[$appointment->patient_id])
                                ? "{$babies[$appointment->patient_id]->name} (B-{$appointment->patient_id})"
                                : "Invalid Patient ({$appointment->patient_type}-{$appointment->patient_id})")
                            : "Invalid Patient ({$appointment->patient_type}-{$appointment->patient_id})");

                    return [
                        'id' => $appointment->id,
                        'patient_name' => $patientName,
                        'type' => $appointment->type,
                        'patient_type' => $appointment->patient_type,
                        'patient_id' => $appointment->patient_id,
                        'time' => Carbon::parse($appointment->time)->format('h:i A'),
                        'status' => $appointment->status,
                        'has_clinic_record' => $appointment->clinicRecord !== null,
                    ];
                })->toArray() : [],
            ];
            $currentDay->addDay();
        }

        return response()->json([
            'month' => $calendarMonth->format('F Y'),
            'month_key' => $calendarMonth->format('Y-m'),
            'days' => $calendarDays,
        ]);
    }
    public function reschedule(Request $request, $appointmentId)
    {
        Log::info('Reschedule attempt', ['appointment_id' => $appointmentId, 'input' => $request->all()]);
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            Log::error('Unauthorized reschedule', ['appointment_id' => $appointmentId]);
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        $midwife = $user->midwife;

        $appointment = Appointment::findOrFail($appointmentId);
        if ($appointment->midwife_id !== $midwife->id) {
            Log::error('Unauthorized reschedule', ['appointment_id' => $appointmentId, 'midwife_id' => $midwife->id]);
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $now = Carbon::now('Asia/Kolkata'); // 01:11 AM IST, July 27, 2025
                    $inputDate = Carbon::parse($value . ' ' . $request->input('time'), 'Asia/Kolkata');
                    if ($inputDate->lte($now)) {
                        $fail('Date and time must be after ' . $now->format('Y-m-d H:i:s') . ' IST.');
                    }
                },
            ],
            'time' => 'required|date_format:H:i',
            'type' => 'required|in:vaccination,checkup,prenatal,other',
            'vaccination_type' => 'required_if:type,vaccination|nullable|string|in:bcg,opv0,hepatitis_b,dtap,hib,ipv,pcv13,rotavirus,mmr',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $appointment->update([
                'date' => $validated['date'],
                'time' => $validated['time'],
                'type' => $validated['type'],
                'vaccination_type' => $validated['type'] === 'vaccination' ? $validated['vaccination_type'] : $appointment->vaccination_type,
                'notes' => $validated['notes'] ?? $appointment->notes,
                'status' => 'scheduled',
                'read' => 0,
            ]);

            if ($appointment->patient_type === 'baby' && $appointment->status === 'scheduled') {
                $baby = Baby::find($appointment->patient_id);
                if ($baby && $baby->user) {
                    $message = "Rescheduled {$appointment->type} appointment for " .
                        \Carbon\Carbon::parse($appointment->date)->format('F d, Y') .
                        ($appointment->time ? ' at ' . \Carbon\Carbon::parse($appointment->time)->format('h:i A') : '') .
                        ($appointment->type === 'vaccination' && $appointment->vaccination_type ? " ({$appointment->vaccination_type})" : '');
                    Notification::create([
                        'user_id' => $baby->user->id,
                        'appointment_id' => $appointment->id,
                        'message' => $message,
                        'read' => false,
                    ]);
                }
            }

            Log::info('Reschedule success', ['appointment_id' => $appointment->id, 'new_date' => $validated['date'], 'new_time' => $validated['time'], 'old_status' => $appointment->getOriginal('status')]);
            return redirect()->route('midwife.appointments')->with('success', 'Appointment rescheduled.');
        } catch (\Exception $e) {
            Log::error('Reschedule failed', ['appointment_id' => $appointment->id, 'error' => $e->getMessage(), 'input' => $request->all()]);
            return redirect()->back()->with('error', 'Reschedule failed. Check logs.');
        }
    }
    public function getPendingVaccinations($appointmentId)
    {
        $user = Auth::user();
        if (!$user || !$user->midwife) {
            Log::error('Unauthorized pending vaccinations fetch attempt', ['appointment_id' => $appointmentId]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $midwife = $user->midwife;

        $appointment = Appointment::findOrFail($appointmentId);
        if ($appointment->midwife_id !== $midwife->id || $appointment->patient_type !== 'baby' || $appointment->type !== 'vaccination') {
            Log::error('Invalid appointment for pending vaccinations', [
                'appointment_id' => $appointmentId,
                'midwife_id' => $midwife->id,
                'patient_type' => $appointment->patient_type,
                'type' => $appointment->type,
            ]);
            return response()->json(['error' => 'Invalid appointment'], 403);
        }

        // Define display names for vaccines
        $vaccineDisplayNames = [
            'bcg' => 'BCG Vaccine',
            'opv0' => 'OPV 0',
            'hepatitis_b' => 'Hepatitis B',
            'dtap' => 'DTaP (Diphtheria, Tetanus, Pertussis)',
            'hib' => 'Hib (Haemophilus influenzae type b)',
            'ipv' => 'Polio (IPV)',
            'pcv13' => 'PCV13 (Pneumococcal)',
            'rotavirus' => 'Rotavirus',
            'mmr' => 'MMR (Measles, Mumps, Rubella)',
            // Add more as needed
        ];

        // Fetch pending or missed vaccinations for the baby
        $vaccinations = Vaccination::where('baby_id', $appointment->patient_id)
            ->whereIn('status', ['pending', 'missed'])
            ->get(['vaccine_name'])
            ->map(function ($vaccination) use ($vaccineDisplayNames) {
                return [
                    'vaccine_name' => $vaccination->vaccine_name,
                    'display_name' => $vaccineDisplayNames[$vaccination->vaccine_name] ?? $vaccination->vaccine_name,
                ];
            })
            ->toArray();

        Log::info('Pending vaccinations fetched', [
            'appointment_id' => $appointmentId,
            'baby_id' => $appointment->patient_id,
            'vaccinations' => $vaccinations,
        ]);

        return response()->json([
            'vaccinations' => $vaccinations,
        ]);
    }
}
