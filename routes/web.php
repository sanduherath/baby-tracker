<?php

use App\Http\Controllers\MidwifeController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PhmController;
use App\Http\Controllers\GrowthController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\BabyController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BabyCheckupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ThriposhaController;
use App\Http\Controllers\VaccinationAlertController;
use App\Http\Controllers\BabyDiaryController;
use App\Http\Controllers\MidwifeDashboardController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/notifications/clear', [DashboardController::class, 'clearNotifications'])->name('notifications.clear');

    Route::get('/moh/dashboard', function () {
        return view('MOH.dashboard');
    })->name('moh.dashboard');

    Route::get('/midwife/dashboard', function () {
        return view('midwife.dashboard');
    })->name('midwife.dashboard');

    

    Route::get('/midwife/add-patient', [MidwifeController::class, 'create'])->name('midwife.addpatient');
    Route::get('/midwife/patients', [PatientController::class, 'index'])->name('midwife.patients');
    Route::post('/midwife/patients/baby', [PatientController::class, 'storeBaby'])->name('midwife.storeBaby');
    Route::post('/midwife/patients/pregnant', [PatientController::class, 'storePregnantWoman'])->name('midwife.storePregnantWoman');
    Route::get('/midwife/baby/{id}', [PatientController::class, 'showBaby'])->name('midwife.baby.profile'); // Renamed to avoid duplicate
    Route::delete('/midwife/baby/{id}', [PatientController::class, 'deleteBaby'])->name('baby.delete');
    Route::get('/midwife/pregnant/{id}', [PatientController::class, 'showPregnant'])->name('pregnant.profile');
    Route::delete('/midwife/pregnant/{id}', [PatientController::class, 'deletePregnant'])->name('pregnant.delete');

    Route::get('/baby/profile', function () {
        // Provide the $baby variable whether the visitor is authenticated via the baby guard
        // or is a normal User who has a related baby.
        if (Auth::guard('baby')->check()) {
            $baby = Auth::guard('baby')->user();
        } elseif (Auth::check() && method_exists(Auth::user(), 'baby')) {
            $baby = Auth::user()->baby;
        } else {
            return redirect()->route('login')->with('status', 'User not authenticated or baby not found.');
        }

        return view('baby.profile', compact('baby'));
    })->name('baby.profile')->middleware('auth:baby'); // Kept as the original profile route

    Route::get('/baby/{babyId}/diary', [BabyDiaryController::class, 'index'])->name('baby.diary')->middleware('auth:baby');
    Route::post('/baby/{babyId}/diary', [BabyDiaryController::class, 'store'])->name('baby.diary.store')->middleware('auth:baby');

    Route::get('/growth/{baby_id}', [GrowthController::class, 'show'])->name('growth.show');

    Route::get('/phm', [PhmController::class, 'index'])->name('phm.index');
    Route::get('/phm/create', [PhmController::class, 'showCreateForm'])->name('phm.create');
    Route::post('/phm', [PhmController::class, 'store'])->name('phm.store');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('midwife.appointments');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('midwife.appointments.store');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'updateStatus'])->name('midwife.appointments.update');
    Route::post('/appointments/{appointment}/clinic-record', [AppointmentController::class, 'storeClinicRecord'])->name('midwife.appointments.clinic-record');
    Route::get('/appointments/search', [AppointmentController::class, 'search'])->name('midwife.appointments.search');
    Route::patch('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('midwife.appointments.reschedule'); // Corrected name
    Route::get('/appointments/calendar', [AppointmentController::class, 'getCalendarAppointments'])->name('midwife.appointments.calendar');
    Route::get('/appointments/{appointment}/pending-vaccinations', [AppointmentController::class, 'getPendingVaccinations'])->name('midwife.appointments.pending-vaccinations');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('midwife.appointments.status');

    Route::get('/baby/checkups', [BabyCheckupController::class, 'index'])->name('baby.checkups');

    Route::get('/midwife/nutrition', [ThriposhaController::class, 'index'])->name('thriposha.distribution');
    Route::post('/thriposha/distribution', [ThriposhaController::class, 'store'])->name('thriposha.distributions.store');
    Route::post('/midwife/thriposha/add-stock', [ThriposhaController::class, 'addStock'])->name('thriposha.addStock');
    Route::post('/midwife/thriposha/place-order', [ThriposhaController::class, 'placeOrder'])->name('thriposha.placeOrder');
    Route::post('/midwife/thriposha/store', [ThriposhaController::class, 'store'])->name('thriposha.store');
    Route::post('/midwife/thriposha/store-order', [ThriposhaController::class, 'storeOrder'])->name('thriposha.storeOrder');
    Route::post('/midwife/thriposha/generate-report', [ThriposhaController::class, 'generateReport'])->name('thriposha.generateReport');

    Route::get('/vaccination-alerts', [VaccinationAlertController::class, 'index'])->name('vaccination_alerts.index');
    Route::post('/vaccination-alerts/{vaccinationId}/resolve', [VaccinationAlertController::class, 'markAsResolved'])->name('vaccination_alerts.resolve');
    Route::post('/vaccination-alerts/schedule', [VaccinationAlertController::class, 'scheduleAppointment'])->name('vaccination_alerts.schedule');
    Route::post('/vaccination-alerts/reschedule', [VaccinationAlertController::class, 'rescheduleAppointment'])->name('vaccination_alerts.reschedule');

    Route::get('/vaccination-record', [PatientController::class, 'showVaccinationRecord'])->name('vaccination.record');
});

// Baby-specific routes (protected by baby guard)
Route::middleware(['auth:baby'])->group(function () {
    Route::get('/baby/dashboard', [BabyController::class, 'dashboard'])->name('baby.dashboard');
    Route::get('/baby/profile', function () {
        if (Auth::guard('baby')->check()) {
            $baby = Auth::guard('baby')->user();
        } elseif (Auth::check() && method_exists(Auth::user(), 'baby')) {
            $baby = Auth::user()->baby;
        } else {
            return redirect()->route('login')->with('status', 'User not authenticated or baby not found.');
        }

        return view('baby.profile', compact('baby'));
    })->name('baby.profile');

    Route::get('/baby/{babyId}/diary', [BabyDiaryController::class, 'index'])->name('baby.diary');
    Route::post('/baby/{babyId}/diary', [BabyDiaryController::class, 'store'])->name('baby.diary.store');
});

// Non-auth routes (outside middleware group)
Route::post('/patients/baby', [PatientController::class, 'storeBaby'])->name('patients.storeBaby');
Route::post('/patients/pregnant', [PatientController::class, 'storePregnantWoman'])->name('patients.storePregnantWoman');
Route::post('/appointments/{appointmentId}/clinic-record', [AppointmentController::class, 'storeClinicRecord'])->name('appointments.storeClinicRecord');
Route::post('/appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');


Route::get('/midwife/dashboard', [MidwifeDashboardController::class, 'index'])->name('midwife.dashboard')->middleware('auth');

use App\Http\Controllers\ReportController;

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');

// Development helper: log in as a baby by ID (only in local environment)
Route::get('/_dev/login-as-baby/{id}', function ($id) {
    if (! app()->environment('local')) {
        abort(403, 'Not allowed');
    }

    Auth::guard('baby')->loginUsingId($id);
    return redirect()->route('baby.dashboard');
});
