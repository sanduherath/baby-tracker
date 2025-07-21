<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\ClinicRecord;
use App\Models\Baby;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BabyCheckupController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->baby) {
            Log::error('No authenticated user or baby not found.', [
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('login')->with('status', 'User not authenticated or baby not found.');
        }

        $baby = Auth::user()->baby;
        $today = Carbon::today('Asia/Kolkata');
        $highlightedAppointmentId = $request->query('appointment_id');

        // Fetch upcoming appointments
        $upcomingAppointments = Appointment::where('patient_type', 'baby')
            ->where('patient_id', $baby->id)
            ->where('status', 'scheduled')
            ->whereDate('date', '>=', $today)
            ->with('midwife')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Fetch checkup history
        $historyRecords = ClinicRecord::where('patient_type', 'baby')
            ->where('patient_id', $baby->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch notifications (unread appointments)
        $notifications = Appointment::where('patient_type', 'baby')
            ->where('patient_id', $baby->id)
            ->where('read', 0)
            ->whereDate('date', '>=', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        // Mark notification as read if visiting the appointment
        if ($highlightedAppointmentId) {
            Appointment::where('id', $highlightedAppointmentId)
                ->where('patient_type', 'baby')
                ->where('patient_id', $baby->id)
                ->update(['read' => 1]);
        }

        Log::info('Retrieved baby checkup data:', [
            'baby_id' => $baby->id,
            'upcoming_count' => $upcomingAppointments->count(),
            'history_count' => $historyRecords->count(),
            'notification_count' => $notifications->count(),
            'highlighted_appointment_id' => $highlightedAppointmentId,
        ]);

        return view('baby.HealthCheckup', compact(
            'upcomingAppointments',
            'historyRecords',
            'baby',
            'notifications',
            'highlightedAppointmentId'
        ));
    }

    public function clearNotifications(Request $request)
    {
        if (!Auth::check() || !Auth::user()->baby) {
            Log::error('Unauthorized attempt to clear notifications', [
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('login')->with('status', 'User not authenticated.');
        }

        $baby = Auth::user()->baby;
        Appointment::where('patient_type', 'baby')
            ->where('patient_id', $baby->id)
            ->where('read', 0)
            ->update(['read' => 1]);

        Log::info('Notifications cleared for baby', [
            'baby_id' => $baby->id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('status', 'Notifications cleared successfully.');
    }
}
