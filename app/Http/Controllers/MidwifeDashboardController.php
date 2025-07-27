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
        // Step 1: Get the authenticated user's email
        $userEmail = Auth::user()->email;

        // Debug: Check what emails exist in midwives table
        $allMidwifeEmails = DB::table('midwives')->pluck('email')->toArray();
        Log::info('=== DEBUGGING EMAIL MATCH ===');
        Log::info('User Email: "' . $userEmail . '"');
        Log::info('User Email Length: ' . strlen($userEmail));
        Log::info('All Midwife Emails: ' . json_encode($allMidwifeEmails));

        // Check if midwives table has any records at all
        $midwifeCount = DB::table('midwives')->count();
        Log::info('Total midwives in table: ' . $midwifeCount);

        // Try exact match with debugging
        $exactMatch = DB::table('midwives')
            ->where('email', '=', $userEmail)
            ->first();
        Log::info('Exact match result: ' . ($exactMatch ? json_encode($exactMatch) : 'NULL'));

        // Try case-insensitive match
        $caseInsensitiveMatch = DB::table('midwives')
            ->whereRaw('LOWER(email) = LOWER(?)', [$userEmail])
            ->first();
        Log::info('Case insensitive match: ' . ($caseInsensitiveMatch ? json_encode($caseInsensitiveMatch) : 'NULL'));

        // Step 2: Get midwife ID
        $midwifeId = DB::table('midwives')
            ->where('email', $userEmail)
            ->value('id');

        Log::info('Final Midwife ID: ' . ($midwifeId ?? 'NULL'));
        Log::info('=== END DEBUGGING ===');

        if (!$midwifeId) {
            // Handle case where no midwife record exists
            Log::warning('No midwife record found for user email: ' . $userEmail);
            $totalPatients = 0;
            $monthlyAppointments = 0;
            $monthlyVaccinations = 0;
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
        }

        // Pass data to the view
        return view('midwife.dashboard', compact('totalPatients', 'monthlyAppointments', 'monthlyVaccinations'));
    }
}
