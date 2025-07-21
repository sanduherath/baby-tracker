<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use App\Models\Vaccination;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaccinationAlertController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today(); // June 2, 2025
        $tomorrow = Carbon::tomorrow(); // June 3, 2025

        // Fetch babies and their vaccinations with appointments
        $babies = Baby::with(['vaccinations' => function ($query) {
            $query->whereIn('status', ['pending_age', 'missed'])
                  ->with(['appointment' => function ($query) {
                      $query->where('patient_type', 'baby')
                            ->where('midwife_id', Auth::id());
                  }]);
        }])->get();

        $alerts = [];

        foreach ($babies as $baby) {
            foreach ($baby->vaccinations as $vaccination) {
                $dueDate = $this->calculateDueDate($baby->date_of_birth, $vaccination->recommended_age);
                if ($dueDate->isToday()) {
                    $alerts[] = [
                        'vaccination_id' => $vaccination->id,
                        'baby_name' => $baby->name,
                        'baby_id' => $baby->id,
                        'vaccine_name' => $vaccination->vaccine_name,
                        'dose' => $vaccination->dose,
                        'recommended_age' => $vaccination->recommended_age,
                        'status' => $vaccination->status,
                        'due_date' => $dueDate,
                        'appointment' => $vaccination->appointment ? [
                            'id' => $vaccination->appointment->id,
                            'date' => $vaccination->appointment->date,
                            'time' => $vaccination->appointment->time,
                            'notes' => $vaccination->appointment->notes,
                        ] : null,
                    ];
                }
            }
        }

        // Handle search
        $search = $request->input('search');
        if ($search) {
            $alerts = array_filter($alerts, function ($alert) use ($search) {
                return stripos($alert['baby_name'], $search) !== false ||
                       stripos($alert['vaccine_name'], $search) !== false ||
                       stripos($alert['dose'], $search) !== false;
            });
        }

        return view('midwife.alerts', compact('alerts'));
    }

    public function markAsResolved(Request $request, $vaccinationId)
    {
        $vaccination = Vaccination::findOrFail($vaccinationId);
        $vaccination->update(['status' => 'resolved']);

        return response()->json(['success' => 'Alert marked as resolved']);
    }

    public function scheduleAppointment(Request $request)
    {
        $request->validate([
            'vaccination_id' => 'required|exists:vaccinations,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $vaccination = Vaccination::findOrFail($request->vaccination_id);
        $vaccination->update(['status' => 'scheduled']);

        Appointment::create([
            'patient_type' => 'baby',
            'patient_id' => $vaccination->baby_id,
            'midwife_id' => Auth::id(),
            'date' => Carbon::parse($request->appointment_date)->toDateString(),
            'time' => Carbon::parse($request->appointment_time)->toTimeString(),
            'type' => 'vaccination',
            'vaccination_type' => $vaccination->vaccine_name,
            'notes' => $request->notes,
            'status' => 'scheduled',
            'read' => 0,
        ]);

        return response()->json(['success' => 'Appointment scheduled successfully']);
    }

    public function rescheduleAppointment(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        $appointment->update([
            'date' => Carbon::parse($request->appointment_date)->toDateString(),
            'time' => Carbon::parse($request->appointment_time)->toTimeString(),
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        // Update vaccination status
        $vaccination = Vaccination::where('baby_id', $appointment->patient_id)
            ->where('vaccine_name', $appointment->vaccination_type)
            ->first();
        if ($vaccination && $vaccination->status !== 'scheduled') {
            $vaccination->update(['status' => 'scheduled']);
        }

        return response()->json(['success' => 'Appointment rescheduled successfully']);
    }

    private function calculateDueDate($birthDate, $recommendedAge)
    {
        $birth = Carbon::parse($birthDate);
        if ($recommendedAge === 'At birth') {
            return $birth;
        }
        $months = (int) filter_var($recommendedAge, FILTER_SANITIZE_NUMBER_INT);
        return $birth->addMonths($months);
    }
}
