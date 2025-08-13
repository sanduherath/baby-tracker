<?php

use App\Http\Controllers\MidwifeController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\BabyLoginController;
use Illuminate\Support\Facades\Auth;

Route::get('/login', function () {
    return redirect()->route('baby.login.form');
})->name('login');

Route::prefix('baby')->name('baby.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [BabyLoginController::class, 'showLoginForm'])->name('login.form');
        Route::post('/login', [BabyLoginController::class, 'login'])->name('login.submit')->middleware('throttle:5,15');
        Route::get('/reset-password', [BabyLoginController::class, 'showResetForm'])->name('password.reset');
        Route::post('/reset-password', [BabyLoginController::class, 'resetPassword'])->name('password.reset.submit');
        Route::post('/verify-credentials', [BabyLoginController::class, 'verifyCredentials'])->name('verify.credentials');
        Route::get('/info/{email?}', [BabyLoginController::class, 'getBabyInfo'])->name('info');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [BabyLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [BabyLoginController::class, 'dashboard'])->name('dashboard');
    });
});

Route::prefix('midwife')->name('midwife.')->group(function () {
    Route::middleware('auth')->group(function () {
        // Example fix for duplicate name
        Route::get('/appointments/{appointmentId}/clinic-record', [MidwifeController::class, 'showClinicRecord'])->name('appointments.clinic-record.view');
        Route::post('/appointments/{appointmentId}/clinic-record', [MidwifeController::class, 'updateClinicRecord'])->name('appointments.clinic-record.update');
        // Add other midwife routes here
    });
});

Route::get('/baby', function () {
    if (Auth::guard('web')->check()) {
        return redirect()->route('baby.dashboard');
    }
    return redirect()->route('baby.login.form');
});
// Admin Authentication Routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit')->middleware('throttle:5,15');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/notifications/clear', [DashboardController::class, 'clearNotifications'])->name('notifications.clear');

    Route::get('/moh/dashboard', function () {
        return view('MOH.dashboard');
    })->name('moh.dashboard');

    Route::get('/midwife/dashboard', [MidwifeDashboardController::class, 'index'])->name('midwife.dashboard');

    Route::get('/baby/dashboard', [BabyController::class, 'dashboard'])->name('baby.dashboard');

    Route::get('/midwife/add-patient', [MidwifeController::class, 'create'])->name('midwife.addpatient');
    Route::get('/midwife/patients', [PatientController::class, 'index'])->name('midwife.patients');
    Route::post('/midwife/patients/baby', [PatientController::class, 'store-free-agents'])->name('midwife.storeBaby');
    Route::post('/midwife/patients/pregnant', [PatientController::class, 'storePregnantWoman'])->name('midwife.storePregnantWoman');
    Route::get('/midwife/baby/{id}', [PatientController::class, 'showBaby'])->name('midwife.baby.profile');
    Route::delete('/midwife/baby/{id}', [PatientController::class, 'deleteBaby'])->name('baby.delete');
    Route::get('/midwife/pregnant/{id}', [PatientController::class, 'showPregnant'])->name('pregnant.profile');
    Route::delete('/midwife/pregnant/{id}', [PatientController::class, 'deletePregnant'])->name('pregnant.delete');

    Route::get('/baby/profile', function () {
        return view('baby.profile');
    })->name('baby.profile');

    Route::get('/baby/{babyId}/diary', [BabyDiaryController::class, 'index'])->name('baby.diary');
    Route::post('/baby/{babyId}/diary', [BabyDiaryController::class, 'store'])->name('baby.diary.store');

    Route::get('/growth/{baby_id}', [GrowthController::class, 'show'])->name('growth.show');

    Route::get('/phm', [PhmController::class, 'index'])->name('phm.index');
    Route::get('/phm/create', [PhmController::class, 'showCreateForm'])->name('phm.create');
    Route::post('/phm', [PhmController::class, 'store'])->name('phm.store');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('midwife.appointments');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('midwife.appointments.store');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'updateStatus'])->name('midwife.appointments.update');
    Route::post('/appointments/{appointment}/clinic-record', [AppointmentController::class, 'storeClinicRecord'])->name('midwife.appointments.clinic-record');
    Route::get('/appointments/search', [AppointmentController::class, 'search'])->name('midwife.appointments.search');
    Route::patch('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('midwife.appointments.reschedule');
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

// Non-auth routes
Route::post('/patients/baby', [PatientController::class, 'storeBaby'])->name('patients.storeBaby');
Route::post('/patients/pregnant', [PatientController::class, 'storePregnantWoman'])->name('patients.storePregnantWoman');
Route::post('/appointments/{appointmentId}/clinic-record', [AppointmentController::class, 'storeClinicRecord'])->name('midwife.appointments.clinic-record');
Route::post('/appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');
