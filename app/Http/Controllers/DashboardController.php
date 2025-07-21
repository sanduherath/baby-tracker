<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->baby) {
            Log::error('No authenticated user or baby found', ['user_id' => Auth::id()]);
            return redirect()->route('login')->with('status', 'User not authenticated or baby not found.');
        }

        $user = Auth::user();
        $baby = $user->baby;
        $today = Carbon::today('Asia/Kolkata');

        // Fetch unread upcoming appointments for notifications
        $notifications = Appointment::where('patient_type', 'baby')
            ->where('patient_id', $baby->id)
            ->where('status', 'scheduled')
            ->whereDate('date', '>=', $today)
            ->where('read', false)
            ->with('midwife')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        Log::info('Dashboard data fetched', [
            'user_id' => $user->id,
            'notification_count' => $notifications->count(),
        ]);

        return view('baby.dashboard', compact('baby', 'notifications'));
    }

    public function clearNotifications(Request $request)
    {
        $baby = Auth::user()->baby;
        $today = Carbon::today('Asia/Kolkata');

        Appointment::where('patient_type', 'baby')
            ->where('patient_id', $baby->id)
            ->where('status', 'scheduled')
            ->whereDate('date', '>=', $today)
            ->update(['read' => true]);

        Log::info('Notifications cleared', ['user_id' => Auth::user()->id]);

        return redirect()->route('dashboard')->with('success', 'Notifications cleared successfully.');
    }
}
