<?php

use App\Http\Controllers\MidwifeController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PhmController;



Route::get('/midwife/add-patient', [MidwifeController::class, 'create'])->name('midwife.addpatient');
Route::post('/patients/baby', [PatientController::class, 'storeBaby'])->name('patients.storeBaby');
Route::post('/patients/pregnant', [PatientController::class, 'storePregnantWoman'])->name('patients.storePregnantWoman');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Example dashboard route (adjust as needed)
Route::get('/dashboard', function () {
    return view('baby.dashboard');
})->middleware('auth')->name('dashboard');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('throttle:5,1');

use App\Http\Controllers\GrowthController;

Route::get('/growth/{baby_id}', [GrowthController::class, 'show'])->name('growth.show');



Route::get('/phm', [PhmController::class, 'index'])->name('phm.index');
Route::get('/phm/create', [PhmController::class, 'showCreateForm'])->name('phm.create');
Route::post('/phm', [PhmController::class, 'store'])->name('phm.store');




use App\Http\Controllers\AdminLoginController;

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/moh/dashboard', function () {
        return view('MOH.dashboard'); // create this Blade file password(secret123)
    })->name('moh.dashboard');

    Route::get('/midwife/dashboard', function () {
        return view('midwife.dashboard'); // create this Blade file
    })->name('midwife.dashboard');
});
Route::get('/baby/profile', function () {
    return view('baby.profile');
})->name('baby.profile');
Route::get('/baby-profile/{id}', [PatientController::class, 'show'])->name('baby.profile');

Route::get('/vaccination-record', [PatientController::class, 'showVaccinationRecord'])->name('vaccination.record');


use App\Http\Controllers\BabyDiaryController;

Route::middleware(['auth'])->group(function () {
    Route::get('/baby/{babyId}/diary', [BabyDiaryController::class, 'index'])->name('baby.diary');
    Route::post('/baby/{babyId}/diary', [BabyDiaryController::class, 'store'])->name('baby.diary.store');
});
// routes/web.php
use App\Http\Controllers\BabyController;

Route::get('/baby/dashboard', [BabyController::class, 'dashboard'])->name('baby.dashboard')->middleware('auth');


// Existing routes
Route::get('/midwife/patients', [PatientController::class, 'index'])->name('midwife.patients')->middleware('auth');
Route::post('/midwife/patients/baby', [PatientController::class, 'storeBaby'])->name('midwife.storeBaby')->middleware('auth');
Route::post('/midwife/patients/pregnant', [PatientController::class, 'storePregnantWoman'])->name('midwife.storePregnantWoman')->middleware('auth');

// New routes for viewing and deleting
Route::get('/midwife/baby/{id}', [PatientController::class, 'showBaby'])->name('baby.profile')->middleware('auth');
Route::delete('/midwife/baby/{id}', [PatientController::class, 'deleteBaby'])->name('baby.delete')->middleware('auth');
Route::get('/midwife/pregnant/{id}', [PatientController::class, 'showPregnant'])->name('pregnant.profile')->middleware('auth');
Route::delete('/midwife/pregnant/{id}', [PatientController::class, 'deletePregnant'])->name('pregnant.delete')->middleware('auth');

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BabyCheckupController;
Route::middleware(['auth'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('midwife.appointments');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('midwife.appointments.store');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'updateStatus'])->name('midwife.appointments.update');
    Route::post('/appointments/{appointment}/clinic-record', [AppointmentController::class, 'storeClinicRecord'])->name('midwife.appointments.clinic-record');
    Route::get('/appointments/search', [AppointmentController::class, 'search'])->name('midwife.appointments.search');

    Route::get('/baby/checkups', [BabyCheckupController::class, 'index'])->name('baby.checkups');
    Route::delete('/notifications/clear', [BabyCheckupController::class, 'clearNotifications'])->name('notifications.clear');
});

Route::post('/appointments/{appointmentId}/clinic-record', [AppointmentController::class, 'storeClinicRecord'])->name('appointments.storeClinicRecord');
Route::middleware(['auth'])->group(function () {
    Route::patch('appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('midwife.appointments.reschedule');
});
Route::get('/appointments/{appointment}/pending-vaccinations', [App\Http\Controllers\AppointmentController::class, 'getPendingVaccinations'])->name('midwife.appointments.pending-vaccinations');


Route::get('/appointments/calendar', [AppointmentController::class, 'getCalendarAppointments'])->name('midwife.appointments.calendar');
Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('midwife.appointments.status');
Route::middleware(['auth'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('midwife.appointments');
    Route::post('/appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');
    Route::post('/appointments/{appointmentId}/clinic-record', [AppointmentController::class, 'storeClinicRecord'])->name('midwife.appointments.clinic-record');
});

use App\Http\Controllers\DashboardController;

Route::get('/baby/checkups', [BabyCheckupController::class, 'index'])
    ->name('baby.checkups')
    ->middleware('auth');
Route::get('/baby/checkups', [BabyCheckupController::class, 'index'])
    ->name('baby.checkups')
    ->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/baby/checkups', [BabyCheckupController::class, 'index'])
    ->name('baby.checkups')
    ->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::delete('/notifications/clear', [DashboardController::class, 'clearNotifications'])
    ->name('notifications.clear')
    ->middleware('auth');

 use App\Http\Controllers\ThriposhaController;

Route::get('/thriposha/distribution', [ThriposhaController::class, 'index'])->name('thriposha.distribution');
Route::post('/thriposha/distribution', [ThriposhaController::class, 'store'])->name('thriposha.distributions.store');


Route::post('/thriposha/add-stock', [ThriposhaController::class, 'addStock'])->name('thriposha.addStock');
Route::middleware(['auth'])->group(function () {
    Route::get('/midwife/nutrition', [ThriposhaController::class, 'index'])->name('thriposha.distribution');
    Route::post('/midwife/thriposha/store', [ThriposhaController::class, 'store'])->name('thriposha.store');
    Route::post('/midwife/thriposha/add-stock', [ThriposhaController::class, 'addStock'])->name('thriposha.addStock');
    Route::post('/midwife/thriposha/place-order', [ThriposhaController::class, 'placeOrder'])->name('thriposha.placeOrder');
});



Route::get('/midwife/nutrition', [ThriposhaController::class, 'index'])->name('thriposha.distribution');
Route::post('/midwife/thriposha/add-stock', [ThriposhaController::class, 'addStock'])->name('thriposha.addStock');
Route::post('/midwife/thriposha/store-order', [ThriposhaController::class, 'storeOrder'])->name('thriposha.storeOrder');

Route::post('/midwife/thriposha/generate-report', [ThriposhaController::class, 'generateReport'])->name('thriposha.generateReport');

use App\Http\Controllers\VaccinationAlertController;


Route::get('/vaccination-alerts', [VaccinationAlertController::class, 'index'])->name('vaccination_alerts.index');
Route::post('/vaccination-alerts/{vaccinationId}/resolve', [VaccinationAlertController::class, 'markAsResolved'])->name('vaccination_alerts.resolve');
Route::post('/vaccination-alerts/schedule', [VaccinationAlertController::class, 'scheduleAppointment'])->name('vaccination_alerts.schedule');
Route::post('/vaccination-alerts/reschedule', [VaccinationAlertController::class, 'rescheduleAppointment'])->name('vaccination_alerts.reschedule');
