<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MidwifeDashboardController extends Controller
{
    /**
     * Display the midwife dashboard with stats.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Debug Auth issues
        Log::info('=== AUTH DEBUGGING ===');
        Log::info('Auth::check(): ' . (Auth::check() ? 'true' : 'false'));
        Log::info('Auth::id(): ' . (Auth::id() ?? 'NULL'));

        if (Auth::check()) {
            $user = Auth::user();
            Log::info('User exists: ' . ($user ? 'true' : 'false'));
            if ($user) {
                Log::info('User ID: ' . $user->id);
                Log::info('User Email: ' . ($user->email ?? 'NULL'));
                Log::info('User Name: ' . ($user->name ?? 'NULL'));
                Log::info('User object: ' . json_encode($user));
            }
        } else {
            Log::info('User is not authenticated');
            // Redirect to login or handle unauthenticated user
            return redirect()->route('login')->with('error', 'Please login first');
        }

        // Step 1: Get the authenticated user's email from users table
        $userEmail = Auth::user()->email;

        // Step 2: Find the midwife record with matching email and get that midwife's ID
        $midwifeId = DB::table('midwives')
            ->where('email', $userEmail)
            ->value('id');

        Log::info('Final Midwife ID: ' . ($midwifeId ?? 'NULL'));
        Log::info('=== END AUTH DEBUGGING ===');

        if (!$midwifeId) {
            // Handle case where no midwife record exists
            Log::warning('No midwife record found for user email: ' . $userEmail);
            $totalPatients = 0;
            $monthlyAppointments = 0;
            $monthlyVaccinations = 0;
            $upcomingVaccinations = collect([]);
            $upcomingAppointments = collect([]);
        } else {
            // Fetch total patients registered under the midwife from the patients table
            $totalPatients = DB::table('patients')->where('midwife_id', $midwifeId)->count();

            // Fetch appointments for the current month (excluding vaccinations)
            $monthlyAppointments = Appointment::where('midwife_id', $midwifeId)
                ->where('type', '!=', 'vaccination')
                ->whereYear('date', Carbon::now()->year)
                ->whereMonth('date', Carbon::now()->month)
                ->count();

            // Fetch vaccinations from appointments table where type = 'vaccination' for the current month
            $monthlyVaccinations = Appointment::where('midwife_id', $midwifeId)
                ->where('type', 'vaccination')
                ->whereYear('date', Carbon::now()->year)
                ->whereMonth('date', Carbon::now()->month)
                ->count();

            // Fetch upcoming vaccination details (future vaccination appointments)
            // WITH DETAILED PATIENT INFORMATION INCLUDING BABY NAMES
            $upcomingVaccinations = Appointment::where('midwife_id', $midwifeId)
                ->where('type', 'vaccination')
                ->where('date', '>=', Carbon::now()->toDateString())
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->with(['patient' => function($query) {
                    // Select all patient columns to ensure we get baby_name
                    $query->select('*');
                }])
                ->get();

            // Debug vaccination data
            Log::info('=== VACCINATION DEBUGGING ===');
            Log::info('Upcoming vaccinations count: ' . $upcomingVaccinations->count());
            foreach ($upcomingVaccinations as $index => $vaccination) {
                Log::info("Vaccination {$index}:");
                Log::info('- ID: ' . $vaccination->id);
                Log::info('- Patient ID: ' . ($vaccination->patient_id ?? 'NULL'));
                Log::info('- Has Patient: ' . ($vaccination->patient ? 'YES' : 'NO'));
                if ($vaccination->patient) {
                    Log::info('- Patient Name: ' . ($vaccination->patient->name ?? 'NULL'));
                    Log::info('- Baby Name: ' . ($vaccination->patient->baby_name ?? 'NULL'));
                    Log::info('- Patient Data: ' . json_encode($vaccination->patient->toArray()));
                }
            }
            Log::info('=== END VACCINATION DEBUGGING ===');

            // Fetch upcoming appointments (health checkups and other appointments)
            // WITH DETAILED PATIENT INFORMATION INCLUDING BABY NAMES
            $upcomingAppointments = Appointment::where('midwife_id', $midwifeId)
                ->where('type', '!=', 'vaccination') // Exclude vaccinations
                ->where('date', '>=', Carbon::now()->toDateString())
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->with(['patient' => function($query) {
                    // Select all patient columns to ensure we get baby_name
                    $query->select('*');
                }])
                ->get();

            // Debug appointment data
            Log::info('=== APPOINTMENT DEBUGGING ===');
            Log::info('Upcoming appointments count: ' . $upcomingAppointments->count());
            foreach ($upcomingAppointments as $index => $appointment) {
                Log::info("Appointment {$index}:");
                Log::info('- ID: ' . $appointment->id);
                Log::info('- Patient ID: ' . ($appointment->patient_id ?? 'NULL'));
                Log::info('- Has Patient: ' . ($appointment->patient ? 'YES' : 'NO'));
                if ($appointment->patient) {
                    Log::info('- Patient Name: ' . ($appointment->patient->name ?? 'NULL'));
                    Log::info('- Baby Name: ' . ($appointment->patient->baby_name ?? 'NULL'));
                    Log::info('- Patient Data: ' . json_encode($appointment->patient->toArray()));
                }
            }
            Log::info('=== END APPOINTMENT DEBUGGING ===');
        }

        // Pass data to the view
        return view('midwife.dashboard', compact('totalPatients', 'monthlyAppointments', 'monthlyVaccinations', 'upcomingVaccinations', 'upcomingAppointments'));
    }
}
