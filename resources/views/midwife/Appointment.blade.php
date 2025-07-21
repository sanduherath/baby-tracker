<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Appointment Management | Midwife System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --primary-blue: #13646d;
            --secondary-blue: #4285f4;
            --light-blue: #e8f0fe;
            --dark-blue: #0c2d48;
            --accent-blue: #8ab4f8;
            --teal: #2b7c85;
            --teal-dark: #175873;
            --teal-light: #87aca3;
            --navy: #0c1446;
            --gradient-start: #2b7c85;
            --gradient-end: #2b7c85;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue) 100%);
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        .midphoto {
            height: 80px;
            width: 80px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .midphoto:hover {
            transform: scale(1.05);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 5px;
            border-radius: 5px;
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Mobile Header */
        .mobile-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--primary-blue);
            color: white;
            z-index: 900;
            display: flex;
            align-items: center;
            padding: 0 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Menu Toggle Button */
        .menu-toggle {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            padding: 5px 10px;
        }

        /* Overlay for mobile menu */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        /* Top Navigation Bar */
        .top-bar {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .back-btn {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .back-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }

        .back-btn i {
            margin-right: 6px;
        }

        .profile-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            color: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid white;
        }

        .profile-circle:hover {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        /* Search box */
        .search-box {
            max-width: 300px;
            border-radius: 8px;
            border: none;
            padding: 8px 15px;
            background-color: rgba(255, 255, 255, 0.636);
            color: white;
            transition: all 0.3s;
        }

        .search-box:focus {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            box-shadow: none;
        }

        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-btn {
            color: rgba(255, 255, 255, 0.7);
            border: none;
            background: transparent;
        }

        /* Appointment Tabs */
        .nav-pills .nav-link {
            color: var(--navy);
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            margin-right: 8px;
        }

        .nav-pills .nav-link.active {
            background-color: var(--teal);
            color: white;
        }

        /* Calendar Styles */
        .calendar-header {
            background-color: var(--teal);
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 10px;
            text-align: center;
            font-weight: 600;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #dee2e6;
        }

        .calendar-day-header {
            background-color: var(--teal-light);
            padding: 8px;
            text-align: center;
            font-weight: 600;
        }

        .calendar-day {
            background-color: white;
            min-height: 100px;
            padding: 5px;
            position: relative;
        }

        .calendar-day.today {
            background-color: #e8f4fe;
            border: 2px solid var(--teal);
        }

        .day-number {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .appointment-badge {
            font-size: 0.75rem;
            padding: 2px 5px;
            margin: 2px 0;
            border-radius: 4px;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .appointment-badge.vaccination {
            background-color: #d4edda;
            color: #155724;
        }

        .appointment-badge.checkup {
            background-color: #fff3cd;
            color: #856404;
        }

        .appointment-badge.prenatal {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        /* Table Styles */
        .table-container {
            max-height: calc(100vh - 250px);
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .table th {
            background-color: var(--teal);
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table td {
            vertical-align: middle;
        }

        .patient-name {
            padding-left: 2em;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-scheduled {
            background-color: #d4edda;
            color: #155724;
        }

        .status-completed {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .status-canceled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 2px;
        }

        .btn-primary {
            background-color: var(--teal);
            border-color: var(--teal);
            border-radius: 20px;
            padding: 6px 16px;
        }

        /* Smaller Calendar Styles */
        .calendar-grid {
            font-size: 12px;
        }

        .calendar-day {
            min-height: 60px;
            padding: 3px;
        }

        .day-number {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .appointment-badge {
            font-size: 10px;
            padding: 1px 3px;
            margin: 1px 0;
        }

        @media (max-width: 768px) {
            .calendar-grid {
                font-size: 10px;
            }

            .calendar-day {
                min-height: 40px;
                padding: 2px;
            }

            .day-number {
                font-size: 10px;
            }

            .appointment-badge {
                font-size: 8px;
                padding: 1px 2px;
            }
        }

        /* Timeline for History */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: "";
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--teal-light);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -30px;
            top: 10px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--teal);
            border: 2px solid white;
        }

        .timeline-date {
            font-weight: 600;
            color: var(--teal-dark);
        }

        .timeline-content {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .arrow a {
            text-decoration: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding-top: 80px;
            }

            .mobile-header {
                display: flex;
            }

            .top-bar {
                padding: 12px 0;
            }

            .back-btn {
                padding: 6px 12px;
                font-size: 13px;
            }

            .search-box {
                max-width: 200px;
                padding: 6px 12px;
            }

            .nav-pills {
                flex-wrap: nowrap;
                overflow-x: auto;
                padding-bottom: 8px;
            }

            .nav-pills .nav-link {
                white-space: nowrap;
                font-size: 14px;
                padding: 6px 12px;
            }

            .table-container {
                max-height: calc(100vh - 300px);
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 14px;
            }

            .action-btn {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }

            .arrow {
                font-size: 15px;
            }

            .calendar-day {
                min-height: 60px;
                font-size: 12px;
            }

            .appointment-badge {
                font-size: 0.6rem;
                padding: 1px 3px;
            }
        }

        .status-completed {
            background-color: #39d773;
            color: #38413c;
        }

        .status-missed {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Debug Styles */
        .debug-info {
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <script>
        // Auto close alerts after 6 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Bootstrap 5 fade out
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 300); // Remove from DOM after fade
            });
        }, 3000);
    </script>
    <!-- Mobile Header -->
    <div class="mobile-header d-lg-none">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0">Appointment Management</h5>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column p-3 text-white" style="height: 100%">
            <div class="text-center mb-4 mt-3 d-none d-lg-block">
                <img src="" class="rounded-circle mb-2 midphoto" alt="Profile" id="profileImage"
                    data-bs-toggle="modal" data-bs-target="#profileModal" />
                <h5>{{ Auth::user()->midwife->name ?? 'Midwife Name' }}</h5>
                <small class="text-white-50">Registered Midwife</small>
            </div>
             <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('midwife.dashboard') }}" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.patients') }}" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-baby"></i> My Patients
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.appointments') }}" class="nav-link active" style="color: #f8f9fa;">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </li>

                <li>
                    <a href="{{ route('thriposha.distribution') }}" class="nav-link " style="color: #f8f9fa;">
                        <i class="fas fa-utensils"></i> Nutrition
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-file-medical"></i> Reports
                    </a>
                </li>

            </ul>
            <div class="mt-auto">
                <a href="" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    @foreach ($todayAppointments->merge($upcomingAppointments) as $appointment)
        <div class="modal fade" id="rescheduleModal{{ $appointment->id }}" tabindex="-1"
            aria-labelledby="rescheduleModalLabel{{ $appointment->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-teal text-white">
                        <h5 class="modal-title" id="rescheduleModalLabel{{ $appointment->id }}">
                            <i class="fas fa-calendar-alt me-2"></i> Reschedule Appointment
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('midwife.appointments.update', $appointment->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="reschedule">
                            <div class="mb-3">
                                <label for="rescheduleDate{{ $appointment->id }}" class="form-label">Date</label>
                                <input type="date" class="form-control" id="rescheduleDate{{ $appointment->id }}"
                                    name="date" value="{{ $appointment->date }}" required
                                    min="{{ now()->toDateString() }}">
                            </div>
                            <div class="mb-3">
                                <label for="rescheduleTime{{ $appointment->id }}" class="form-label">Time</label>
                                <input type="time" class="form-control" id="rescheduleTime{{ $appointment->id }}"
                                    name="time" value="{{ $appointment->time }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="rescheduleType{{ $appointment->id }}" class="form-label">Appointment
                                    Type</label>
                                <select class="form-select" id="rescheduleType{{ $appointment->id }}" name="type"
                                    required>
                                    <option value="vaccination"
                                        {{ $appointment->type === 'vaccination' ? 'selected' : '' }}>Vaccination
                                    </option>
                                    <option value="checkup" {{ $appointment->type === 'checkup' ? 'selected' : '' }}>
                                        Health Checkup</option>
                                    <option value="prenatal"
                                        {{ $appointment->type === 'prenatal' ? 'selected' : '' }}>Prenatal Checkup
                                    </option>
                                    <option value="other" {{ $appointment->type === 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>
                            @if ($appointment->type === 'vaccination')
                                <div class="mb-3" id="vaccinationTypeContainer{{ $appointment->id }}">
                                    <label for="rescheduleVaccinationType{{ $appointment->id }}"
                                        class="form-label">Vaccination Type</label>
                                    <select class="form-select" id="rescheduleVaccinationType{{ $appointment->id }}"
                                        name="vaccination_type">
                                        <option value="bcg"
                                            {{ $appointment->vaccination_type === 'bcg' ? 'selected' : '' }}>BCG
                                        </option>
                                        <option value="pentavalent1"
                                            {{ $appointment->vaccination_type === 'pentavalent1' ? 'selected' : '' }}>
                                            Pentavalent 1</option>
                                        <option value="pentavalent2"
                                            {{ $appointment->vaccination_type === 'pentavalent2' ? 'selected' : '' }}>
                                            Pentavalent 2</option>
                                        <option value="pentavalent3"
                                            {{ $appointment->vaccination_type === 'pentavalent3' ? 'selected' : '' }}>
                                            Pentavalent 3</option>
                                        <option value="mmr"
                                            {{ $appointment->vaccination_type === 'mmr' ? 'selected' : '' }}>MMR
                                        </option>
                                    </select>
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="rescheduleNotes{{ $appointment->id }}" class="form-label">Notes</label>
                                <textarea class="form-control" id="rescheduleNotes{{ $appointment->id }}" name="notes" rows="3">{{ $appointment->notes }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="main-content" id="mainContent">
        <!-- Top Navigation Bar -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center arrow">
                        <a href="{{ url('dash') }}" class="back-btn me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0 d-none d-md-block text-white">Appointment Management</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group search-box me-3">
                            <input type="text" class="form-control bg-transparent border-0"
                                placeholder="Search appointments..." />
                            <button class="btn search-btn" type="button" id="searchButton">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Debug Information -->
        {{-- <div class="container-fluid py-2">
            <div class="debug-info">
                <strong>Debug Info:</strong><br />
                Today's Appointments: {{ $todayAppointments->count() }}
                (Babies: {{ $todayAppointments->where('patient_type', 'baby')->count() }},
                Pregnant: {{ $todayAppointments->where('patient_type', 'pregnant')->count() }})<br />
                Upcoming Appointments: {{ $upcomingAppointments->count() }}
                (Babies: {{ $upcomingAppointments->where('patient_type', 'baby')->count() }},
                Pregnant: {{ $upcomingAppointments->where('patient_type', 'pregnant')->count() }})<br />
                History Appointments: {{ $historyAppointments->count() }}
                (Babies: {{ $historyAppointments->where('patient_type', 'baby')->count() }},
                Pregnant: {{ $historyAppointments->where('patient_type', 'pregnant')->count() }})<br />
                Babies Available: {{ $babies->count() }}<br />
                Pregnant Women Available: {{ $pregnantWomen->count() }}
            </div>
        </div> --}}

        <!-- Appointment Content -->
        <div class="container-fluid py-4">
            <!-- Appointment Tabs -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <button class="nav-link active" id="upcoming-tab">
                            <i class="fas fa-calendar-alt me-1"></i> Upcoming
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="history-tab">
                            <i class="fas fa-history me-1"></i> History
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="calendar-tab">
                            <i class="far fa-calendar me-1"></i> Calendar
                        </button>
                    </li>
                </ul>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
                    <i class="fas fa-plus me-1"></i> New Appointment
                </button>
            </div>

            <!-- Upcoming Appointments Table -->
            <div id="upcomingView">
                <!-- Today's Appointments -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Today's Appointments</h5>
                    <div class="text-muted">{{ now()->format('l, F d, Y') }}</div>
                </div>
                <div class="table-container mb-4" id="todayAppointmentsTable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 15%">Time</th>
                                <th style="width: 20%">Patient</th>
                                <th style="width: 15%">Age</th>
                                <th style="width: 15%">Type</th>
                                <th style="width: 20%">Purpose</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Actions</th> <!-- Changed from 5% to 10% -->
                            </tr>
                        </thead>
                        <tbody id="todayAppointmentsBody">
                            @if ($todayAppointments->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No appointments for today.</td>
                                </tr>
                            @else
                                @foreach ($todayAppointments as $appointment)
                                    <tr data-appointment-id="{{ $appointment->id }}">
                                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                                        <td class="patient-name">
                                            @if ($appointment->patient)
                                                {{ $appointment->patient->name }}
                                                ({{ $appointment->patient_type === 'baby' ? 'B' : 'PW' }}-{{ $appointment->patient_id }})
                                            @else
                                                @if ($appointment->patient_type === 'baby')
                                                    @php
                                                        $baby = $babies->where('id', $appointment->patient_id)->first();
                                                    @endphp
                                                    @if ($baby)
                                                        {{ $baby->name }}
                                                        (B-{{ $appointment->patient_id }})
                                                    @else
                                                        <span class="text-danger">Invalid Patient
                                                            ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})
                                                            - Baby Record Not Found</span>
                                                    @endif
                                                @else
                                                    <span class="text-danger">Invalid Patient
                                                        ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($appointment->patient)
                                                {{ round(\Carbon\Carbon::parse($appointment->patient->dob)->floatDiffInYears(now()), 1) }}
                                                years
                                            @else
                                                @if ($appointment->patient_type === 'baby')
                                                    @php
                                                        $baby = $babies->where('id', $appointment->patient_id)->first();
                                                    @endphp
                                                    @if ($baby)
                                                        {{ round(\Carbon\Carbon::parse($baby->birth_date)->floatDiffInMonths(now()), 1) }}
                                                        months
                                                    @else
                                                        <span class="text-danger">N/A</span>
                                                    @endif
                                                @else
                                                    <span class="text-danger">N/A</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($appointment->patient_type) }}</td>
                                        <td>
                                            {{ ucfirst($appointment->type) }}
                                            @if ($appointment->type === 'vaccination' && $appointment->vaccination_type)
                                                ({{ $appointment->vaccination_type }})
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                                        </td>
                                        <td class="action-buttons">
                                            <div class="d-flex gap-2">
                                                @if ($appointment->status === 'missed')
                                                    <button type="button"
                                                        class="btn btn-outline-warning btn-sm action-btn reschedule-btn"
                                                        title="Reschedule" data-bs-toggle="modal"
                                                        data-bs-target="#rescheduleModal{{ $appointment->id }}">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </button>
                                                @elseif ($appointment->status === 'completed')
                                                    <!-- No button for completed -->
                                                @elseif ($appointment->status === 'scheduled')
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm action-btn clinic-btn"
                                                        title="Enter Clinic Details" data-bs-toggle="modal"
                                                        data-bs-target="#clinicRecordModal{{ $appointment->id }}">
                                                        <i class="fas fa-clipboard"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-outline-warning btn-sm action-btn reschedule-btn"
                                                        title="Reschedule" data-bs-toggle="modal"
                                                        data-bs-target="#rescheduleModal{{ $appointment->id }}">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @foreach ($todayAppointments as $appointment)
                    <div class="modal fade" id="rescheduleModal{{ $appointment->id }}" tabindex="-1"
                        aria-labelledby="rescheduleModalLabel{{ $appointment->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rescheduleModalLabel{{ $appointment->id }}">
                                        Reschedule Appointment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('midwife.appointments.reschedule', $appointment->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="date{{ $appointment->id }}" class="form-label">New
                                                Date</label>
                                            <input type="date" name="date" id="date{{ $appointment->id }}"
                                                class="form-control" value="{{ $appointment->date }}" required
                                                min="{{ today()->toDateString() }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="time{{ $appointment->id }}" class="form-label">New
                                                Time</label>
                                            <input type="time" name="time" id="time{{ $appointment->id }}"
                                                class="form-control" value="{{ $appointment->time }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Reschedule</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Clinic Record Modals -->
                @foreach ($todayAppointments as $appointment)
    <div class="modal fade" id="clinicRecordModal{{ $appointment->id }}" tabindex="-1" aria-labelledby="clinicRecordModalLabel{{ $appointment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title" id="clinicRecordModalLabel{{ $appointment->id }}">
                        <i class="fas fa-clipboard me-2"></i> Enter Clinic Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('midwife.appointments.clinic-record', $appointment->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="weight{{ $appointment->id }}" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control" id="weight{{ $appointment->id }}" name="weight" step="0.01" min="0" max="200">
                        </div>
                        <div class="mb-3">
                            <label for="height{{ $appointment->id }}" class="form-label">Height (cm)</label>
                            <input type="number" class="form-control" id="height{{ $appointment->id }}" name="height" step="0.01" min="0" max="200">
                        </div>
                        @if ($appointment->type === 'checkup')
                            <div class="mb-3">
                                <label for="headCircumference{{ $appointment->id }}" class="form-label">Head Circumference (cm)</label>
                                <input type="number" class="form-control" id="headCircumference{{ $appointment->id }}" name="head_circumference" step="0.01" min="0" max="100">
                            </div>
                            <div class="mb-3">
                                <label for="nutrition{{ $appointment->id }}" class="form-label">Nutrition Provided</label>
                                <select class="form-select" id="nutrition{{ $appointment->id }}" name="nutrition">
                                    <option value="">Select nutrition</option>
                                    <option value="thriposha">Thriposha</option>
                                    <option value="vitamins">Vitamins</option>
                                </select>
                            </div>
                            <div class="mb-3" id="thriposhaPacketsContainer{{ $appointment->id }}" style="display: none;">
                                <label for="thriposhaPackets{{ $appointment->id }}" class="form-label">Thriposha Packets</label>
                                <select class="form-select" id="thriposhaPackets{{ $appointment->id }}" name="thriposha_packets">
                                    <option value="">Select number of packets</option>
                                    <option value="1">1 Packet</option>
                                    <option value="2">2 Packets</option>
                                </select>
                            </div>
                        @elseif ($appointment->type === 'vaccination')
                            <div class="mb-3">
                                <label for="vaccinationName{{ $appointment->id }}" class="form-label">Vaccination Name</label>
                                <select class="form-select" id="vaccinationName{{ $appointment->id }}" name="vaccination_name" required>
                                    <option value="">Select vaccination</option>
                                    <!-- Options will be populated dynamically via JavaScript -->
                                </select>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="midwifeAccommodations{{ $appointment->id }}" class="form-label">Midwife Accommodations</label>
                            <textarea class="form-control" id="midwifeAccommodations{{ $appointment->id }}" name="midwife_accommodations" rows="4"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Thriposha packets visibility
    document.querySelectorAll('[id^="nutrition"]').forEach(select => {
        select.addEventListener('change', function() {
            const modalId = this.id.replace('nutrition', '');
            const thriposhaContainer = document.getElementById(`thriposhaPacketsContainer${modalId}`);
            const thriposhaPackets = document.getElementById(`thriposhaPackets${modalId}`);
            if (this.value === 'thriposha') {
                thriposhaContainer.style.display = 'block';
                thriposhaPackets.setAttribute('required', '');
            } else {
                thriposhaContainer.style.display = 'none';
                thriposhaPackets.removeAttribute('required');
            }
        });
    });

    // Fetch pending/missed vaccinations when modal opens
    document.querySelectorAll('[id^="clinicRecordModal"]').forEach(modal => {
        modal.addEventListener('show.bs.modal', function(event) {
            const modalId = this.id.replace('clinicRecordModal', '');
            const appointmentId = modalId;
            const vaccinationSelect = document.getElementById(`vaccinationName${modalId}`);

            if (vaccinationSelect) { // Only for vaccination appointments
                fetch(`/appointments/${appointmentId}/pending-vaccinations`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Clear existing options except the placeholder
                    vaccinationSelect.innerHTML = '<option value="">Select vaccination</option>';
                    if (data.vaccinations && data.vaccinations.length > 0) {
                        data.vaccinations.forEach(vaccine => {
                            const option = document.createElement('option');
                            option.value = vaccine.vaccine_name;
                            option.textContent = vaccine.display_name || vaccine.vaccine_name.toUpperCase();
                            vaccinationSelect.appendChild(option);
                        });
                    } else {
                        // Optionally disable the dropdown if no vaccines are available
                        vaccinationSelect.innerHTML += '<option value="" disabled>No pending or missed vaccinations</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching pending vaccinations:', error);
                    vaccinationSelect.innerHTML += '<option value="" disabled>Error loading vaccinations</option>';
                });
            }
        });
    });
});
</script>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('[id^="nutrition"]').forEach(select => {
                            select.addEventListener('change', function() {
                                const modalId = this.id.replace('nutrition', '');
                                const thriposhaContainer = document.getElementById(
                                    `thriposhaPacketsContainer${modalId}`);
                                const thriposhaPackets = document.getElementById(`thriposhaPackets${modalId}`);
                                if (this.value === 'thriposha') {
                                    thriposhaContainer.style.display = 'block';
                                    thriposhaPackets.setAttribute('required', '');
                                } else {
                                    thriposhaContainer.style.display = 'none';
                                    thriposhaPackets.removeAttribute('required');
                                }
                            });
                        });
                    });
                </script>
                <!-- Clinic Record Modals -->
                {{-- @foreach ($todayAppointments as $appointment)
                    <div class="modal fade" id="clinicRecordModal{{ $appointment->id }}" tabindex="-1"
                        aria-labelledby="clinicRecordModalLabel{{ $appointment->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-teal text-white">
                                    <h5 class="modal-title" id="clinicRecordModalLabel{{ $appointment->id }}">
                                        <i class="fas fa-clipboard me-2"></i> Enter Clinic Details
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('midwife.appointments.clinic-record', $appointment->id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="weight{{ $appointment->id }}" class="form-label">Weight
                                                (kg)
                                            </label>
                                            <input type="number" class="form-control"
                                                id="weight{{ $appointment->id }}" name="weight" step="0.01"
                                                min="0" max="200">
                                        </div>
                                        <div class="mb-3">
                                            <label for="height{{ $appointment->id }}" class="form-label">Height
                                                (cm)</label>
                                            <input type="number" class="form-control"
                                                id="height{{ $appointment->id }}" name="height" step="0.01"
                                                min="0" max="200">
                                        </div>
                                        @if ($appointment->type === 'checkup')
                                            <div class="mb-3">
                                                <label for="headCircumference{{ $appointment->id }}"
                                                    class="form-label">Head Circumference (cm)</label>
                                                <input type="number" class="form-control"
                                                    id="headCircumference{{ $appointment->id }}"
                                                    name="head_circumference" step="0.01" min="0"
                                                    max="100">
                                            </div>
                                            <div class="mb-3">
                                                <label for="nutrition{{ $appointment->id }}"
                                                    class="form-label">Nutrition Provided</label>
                                                <select class="form-select" id="nutrition{{ $appointment->id }}"
                                                    name="nutrition">
                                                    <option value="">Select nutrition</option>
                                                    <option value="thriposha">Thriposha</option>
                                                    <option value="vitamins">Vitamins</option>
                                                    <option value="both">Thriposha & Vitamins</option>
                                                    <option value="none">None</option>
                                                </select>
                                            </div>
                                        @elseif ($appointment->type === 'vaccination')
                                            <div class="mb-3">
                                                <label for="vaccinationName{{ $appointment->id }}"
                                                    class="form-label">Vaccination Name</label>
                                                <select class="form-select"
                                                    id="vaccinationName{{ $appointment->id }}"
                                                    name="vaccination_name" required>
                                                    <option value="">Select vaccination</option>
                                                    <option value="bcg">BCG</option>
                                                    <option value="pentavalent1">Pentavalent 1</option>
                                                    <option value="pentavalent2">Pentavalent 2</option>
                                                    <option value="pentavalent3">Pentavalent 3</option>
                                                    <option value="mmr">MMR</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="midwifeAccommodations{{ $appointment->id }}"
                                                class="form-label">Midwife Accommodations</label>
                                            <textarea class="form-control" id="midwifeAccommodations{{ $appointment->id }}" name="midwife_accommodations"
                                                rows="4"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i> Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach --}}

                <!-- Upcoming Appointments -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Upcoming Appointments</h5>
                    <div class="text-muted">Next 7 Days</div>
                </div>
                <div class="table-container mb-4" id="upcomingAppointmentsTable">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 15%">Date & Time</th>
                                <th style="width: 15%">Patient</th>
                                <th style="width: 15%">Age</th>
                                <th style="width: 10%">Type</th>
                                <th style="width: 20%">Purpose</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="upcomingAppointmentsBody">
                            @if ($upcomingAppointments->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No upcoming appointments.</td>
                                </tr>
                            @else
                                @foreach ($upcomingAppointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('M d, h:i A') }}</td>
                                        <td class="patient-name">
                                            @if ($appointment->patient)
                                                {{ $appointment->patient->name }}
                                                ({{ $appointment->patient_type === 'baby' ? 'B' : 'PW' }}-{{ $appointment->patient_id }})
                                            @else
                                                @if ($appointment->patient_type === 'baby')
                                                    @php
                                                        $baby = $babies->where('id', $appointment->patient_id)->first();
                                                    @endphp
                                                    @if ($baby)
                                                        {{ $baby->name }}
                                                        (B-{{ $appointment->patient_id }})
                                                    @else
                                                        <span class="text-danger">Invalid Patient
                                                            ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})
                                                            - Baby Record Not Found</span>
                                                    @endif
                                                @else
                                                    <span class="text-danger">Invalid Patient
                                                        ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($appointment->patient)
                                                {{ round(\Carbon\Carbon::parse($appointment->patient->dob)->floatDiffInYears(now()), 1) }}
                                                years
                                            @else
                                                @if ($appointment->patient_type === 'baby')
                                                    @php
                                                        $baby = $babies->where('id', $appointment->patient_id)->first();
                                                    @endphp
                                                    @if ($baby)
                                                        {{ round(\Carbon\Carbon::parse($baby->birth_date)->floatDiffInMonths(now()), 1) }}
                                                        months
                                                    @else
                                                        <span class="text-danger">N/A</span>
                                                    @endif
                                                @else
                                                    <span class="text-danger">N/A</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($appointment->patient_type) }}</td>
                                        <td>
                                            {{ ucfirst($appointment->type) }}
                                            @if ($appointment->type === 'vaccination' && $appointment->vaccination_type)
                                                ({{ $appointment->vaccination_type }})
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary btn-sm action-btn"
                                                title="View" data-bs-toggle="modal"
                                                data-bs-target="#viewModal{{ $appointment->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if ($appointment->status !== 'completed')
                                                <button type="button"
                                                    class="btn btn-outline-warning btn-sm action-btn"
                                                    title="Reschedule" data-bs-toggle="modal"
                                                    data-bs-target="#rescheduleModal{{ $appointment->id }}">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Search JavaScript -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchInput = document.querySelector('.search-box input');
                        const searchButton = document.getElementById('searchButton');
                        const todayTableBody = document.getElementById('todayAppointmentsBody');
                        const upcomingTableBody = document.getElementById('upcomingAppointmentsBody');

                        function searchAppointments() {
                            const query = searchInput.value.trim();
                            if (!query) {
                                location.reload();
                                return;
                            }

                            fetch(`/appointments/search?query=${encodeURIComponent(query)}`, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                    },
                                })
                                .then(response => response.json())
                                .then(data => {
                                    todayTableBody.innerHTML = data.todayAppointments.length > 0 ?
                                        data.todayAppointments
                                        .map(appointment => `
                        <tr data-appointment-id="${appointment.id}">
                            <td>${appointment.time_formatted}</td>
                            <td class="patient-name">${appointment.patient_name || `<span class="text-danger">Invalid Patient (${appointment.patient_type}-${appointment.patient_id})</span>`}</td>
                            <td>${appointment.patient_age || '<span class="text-danger">N/A</span>'}</td>
                            <td>${appointment.patient_type_ucfirst}</td>
                            <td>${appointment.purpose}</td>
                            <td><span class="status-badge status-${appointment.status}">${appointment.status_ucfirst}</span></td>
                            <td class="action-buttons">
                                <div class="d-flex gap-2">
                                    ${
                                        appointment.status === 'missed'
                                            ? `
                                                                                                                                <button type="button" class="btn btn-outline-warning btn-sm action-btn reschedule-btn" title="Reschedule" data-bs-toggle="modal" data-bs-target="#rescheduleModal${appointment.id}">
                                                                                                                                    <i class="fas fa-calendar-alt"></i>
                                                                                                                                </button>
                                                                                                                            `
                                            : appointment.status === 'completed'
                                            ? ''
                                            : appointment.status === 'scheduled'
                                                ? `
                                                                                                                                    <button type="button" class="btn btn-outline-primary btn-sm action-btn clinic-btn" title="Enter Clinic Details" data-bs-toggle="modal" data-bs-target="#clinicRecordModal${appointment.id}">
                                                                                                                                        <i class="fas fa-clipboard"></i>
                                                                                                                                    </button>
                                                                                                                                    <button type="button" class="btn btn-outline-warning btn-sm action-btn reschedule-btn" title="Reschedule" data-bs-toggle="modal" data-bs-target="#rescheduleModal${appointment.id}">
                                                                                                                                        <i class="fas fa-calendar-alt"></i>
                                                                                                                                    </button>
                                                                                                                                `
                                                : ''
                                    }
                                </div>
                            </td>
                        </tr>
                    `)
                                        .join('') :
                                        '<tr><td colspan="7" class="text-center text-muted">No appointments for today.</td></tr>';

                                    upcomingTableBody.innerHTML = data.upcomingAppointments.length > 0 ?
                                        data.upcomingAppointments
                                        .map(appointment => `
                        <tr>
                            <td>${appointment.date_time_formatted}</td>
                            <td class="patient-name">${appointment.patient_name || `<span class="text-danger">Invalid Patient (${appointment.patient_type}-${appointment.patient_id})</span>`}</td>
                            <td>${appointment.patient_age || '<span class="text-danger">N/A</span>'}</td>
                            <td>${appointment.patient_type_ucfirst}</td>
                            <td>${appointment.purpose}</td>
                            <td><span class="status-badge status-${appointment.status}">${appointment.status_ucfirst}</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm action-btn" title="View" data-bs-toggle="modal" data-bs-target="#viewModal${appointment.id}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    ${
                                        appointment.status !== 'completed'
                                            ? `
                                                                                                                                <button type="button" class="btn btn-outline-warning btn-sm action-btn reschedule-btn" title="Reschedule" data-bs-toggle="modal" data-bs-target="#rescheduleModal${appointment.id}">
                                                                                                                                    <i class="fas fa-calendar-alt"></i>
                                                                                                                                </button>
                                                                                                                            `
                                            : ''
                                    }
                                </div>
                            </td>
                        </tr>
                    `)
                                        .join('') :
                                        '<tr><td colspan="7" class="text-center text-muted">No upcoming appointments.</td></tr>';
                                })
                                .catch(error => console.error('Error fetching search results:', error));
                        }

                        searchButton.addEventListener('click', searchAppointments);
                        searchInput.addEventListener('keypress', function(e) {
                            if (e.key === 'Enter') {
                                searchAppointments();
                            }
                        });
                    });
                </script>
            </div>
            <!-- Appointment History -->
            <div id="historyView" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Appointment History</h5>
                    <div class="input-group" style="max-width: 300px">
                        <input type="text" class="form-control" placeholder="Search history..." />
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
                <div class="timeline">
                    @if ($historyAppointments->isEmpty())
                        <div class="text-center text-muted">No appointment history available.</div>
                    @else
                        @foreach ($historyAppointments as $appointment)
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    {{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}</div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>

                                                @if ($appointment->patient)
                                                    {{ $appointment->patient->name }}
                                                    ({{ $appointment->patient_type === 'baby' ? 'B' : 'PW' }}-{{ $appointment->patient_id }})
                                                    - Age:
                                                    {{ round(\Carbon\Carbon::parse($appointment->patient->dob)->floatDiffInYears(now()), 1) }}
                                                @else
                                                    @if ($appointment->patient_type === 'baby')
                                                        @php
                                                            $baby = $babies
                                                                ->where('id', $appointment->patient_id)
                                                                ->first();
                                                        @endphp
                                                        @if ($baby)
                                                            {{ $baby->name }}
                                                            (B-{{ $appointment->patient_id }}) - Age:
                                                            {{ round(\Carbon\Carbon::parse($baby->dob)->floatDiffInYears(now()), 1) }}
                                                        @else
                                                            <span class="text-danger">Invalid Patient
                                                                ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})
                                                                - Baby Record Not Found</span>
                                                        @endif
                                                    @else
                                                        <span class="text-danger">Invalid Patient
                                                            ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})</span>
                                                    @endif
                                                @endif

                                            </strong><br />
                                            <span class="text-muted">
                                                {{ ucfirst($appointment->type) }}
                                                @if ($appointment->type === 'vaccination' && $appointment->vaccination_type)
                                                    ({{ $appointment->vaccination_type }})
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-end">
                                            <span
                                                class="status-badge status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span><br />
                                            <small
                                                class="text-muted">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</small>
                                        </div>
                                    </div>
                                    @if ($appointment->notes)
                                        <div class="mt-2">
                                            <small><strong>Notes:</strong> {{ $appointment->notes }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Calendar View -->
            <div id="calendarView" class="d-none">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" id="calendarMonth">{{ $calendarMonth->format('F Y') }}</h5>
                    <div>
                        <button class="btn btn-outline-secondary btn-sm me-2" id="prevMonth">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm me-2" id="todayMonth">Today</button>
                        <button class="btn btn-outline-secondary btn-sm" id="nextMonth">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="calendar-header">
                    <div class="row text-center">
                        <div class="col">Sun</div>
                        <div class="col">Mon</div>
                        <div class="col">Tue</div>
                        <div class="col">Wed</div>
                        <div class="col">Thu</div>
                        <div class="col">Fri</div>
                        <div class="col">Sat</div>
                    </div>
                </div>
                <div class="calendar-grid" id="calendarGrid">
                    @php
                        $startOfCalendar = $calendarMonth->copy()->startOfMonth()->startOfWeek();
                        $endOfCalendar = $calendarMonth->copy()->endOfMonth()->endOfWeek();
                        $currentDay = $startOfCalendar->copy();
                    @endphp
                    @while ($currentDay <= $endOfCalendar)
                        <div class="calendar-day {{ $currentDay->isToday() ? 'today' : '' }} {{ $currentDay->month != $calendarMonth->month ? 'text-muted' : '' }}"
                            data-date="{{ $currentDay->toDateString() }}">
                            <div class="day-number">{{ $currentDay->day }}</div>
                            @foreach ($calendarAppointments->where('date', $currentDay->toDateString()) as $appointment)
                                @if ($appointment->patient)
                                    <span
                                        class="appointment-badge {{ $appointment->type }} status-{{ $appointment->status }}"
                                        title="{{ $appointment->patient->name }} ({{ $appointment->patient_type === 'baby' ? 'B' : 'PW' }}-{{ $appointment->patient_id }}) {{ ucfirst($appointment->type) }} ({{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}) - {{ ucfirst($appointment->status) }}">
                                        ({{ $appointment->patient_type === 'baby' ? 'B' : 'PW' }}-{{ $appointment->patient_id }})
                                        {{ ucfirst($appointment->type) }}
                                    </span>
                                @else
                                    @if ($appointment->patient_type === 'baby')
                                        @php
                                            $baby = $babies->where('id', $appointment->patient_id)->first();
                                        @endphp
                                        @if ($baby)
                                            <span
                                                class="appointment-badge {{ $appointment->type }} status-{{ $appointment->status }}"
                                                title="{{ $baby->name }} (B-{{ $appointment->patient_id }}) {{ ucfirst($appointment->type) }} ({{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}) - {{ ucfirst($appointment->status) }}">
                                                (B-{{ $appointment->patient_id }}) {{ ucfirst($appointment->type) }}
                                            </span>
                                        @else
                                            <span class="appointment-badge text-danger"
                                                title="Invalid Patient ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})">
                                                Invalid Patient
                                            </span>
                                        @endif
                                    @else
                                        <span class="appointment-badge text-danger"
                                            title="Invalid Patient ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})">
                                            Invalid Patient
                                        </span>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        @php $currentDay->addDay(); @endphp
                    @endwhile
                </div>
            </div>
        </div>
    </div>

    <!-- New Appointment Modal -->
    <div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title" id="newAppointmentModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Schedule New Appointment
                    </h5>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm" action="{{ route('midwife.appointments.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="appointmentPatientType" class="form-label">Patient Type</label>
                            <select class="form-select" id="appointmentPatientType" name="patient_type" required>
                                <option value="">Select patient type</option>
                                <option value="baby">Baby</option>
                                <option value="pregnant">Pregnant Woman</option>
                            </select>
                            @error('patient_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="patientSelect" class="form-label">Patient</label>
                            <select class="form-select" id="patientSelect" name="patient_id" required>
                                <option value="">Select patient</option>
                                @foreach ($babies as $baby)
                                    <option value="{{ $baby->id }}" data-type="baby">{{ $baby->name }}
                                        (B-{{ $baby->id }})</option>
                                @endforeach
                                @foreach ($pregnantWomen as $pregnantWoman)
                                    <option value="{{ $pregnantWoman->id }}" data-type="pregnant">
                                        {{ $pregnantWoman->name }} (PW-{{ $pregnantWoman->id }})</option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label for="appointmentDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="appointmentDate" name="date"
                                    required min="{{ now()->toDateString() }}" />
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="appointmentTime" class="form-label">Time</label>
                                <input type="time" class="form-control" id="appointmentTime" name="time"
                                    required />
                                @error('time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentType" class="form-label">Appointment Type</label>
                            <select class="form-select" id="appointmentType" name="type" required>
                                <option value="">Select type</option>
                                <option value="vaccination">Vaccination</option>
                                <option value="checkup">Health Checkup</option>
                                <option value="prenatal">Prenatal Checkup</option>
                                <option value="other">Other</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="vaccinationTypeContainer" style="display: none;">
                            <label for="vaccinationType" class="form-label">Vaccination Type</label>
                            <select class="form-select" id="vaccinationType" name="vaccination_type">
                                <option value="">Select vaccination</option>
                                <option value="bcg">BCG Vaccine</option>
                                <option value="opv0">OPV 0</option>
                                <option value="hepatitis_b">Hepatitis B</option>
                                <option value="dtap">DTaP (Diphtheria, Tetanus, Pertussis)</option>
                                <option value="hib">Hib (Haemophilus influenzae type b)</option>
                                <option value="ipv">Polio (IPV)</option>
                                <option value="pcv13">PCV13 (Pneumococcal)</option>
                                <option value="rotavirus">Rotavirus</option>
                                <option value="mmr">MMR (Measles, Mumps, Rubella)</option>
                            </select>
                            @error('vaccination_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3" id="nextVaccinationContainer" style="display: none;">
                            <label class="form-label">Next Recommended Vaccination</label>
                            <p id="nextVaccination" class="form-text text-muted"></p>
                        </div>
                        <div class="mb-3">
                            <label for="appointmentNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="appointmentNotes" name="notes" rows="3"></textarea>
                            @error('notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const appointmentTypeSelect = document.getElementById('appointmentType');
            const vaccinationTypeContainer = document.getElementById('vaccinationTypeContainer');
            const vaccinationTypeSelect = document.getElementById('vaccinationType');
            const patientSelect = document.getElementById('patientSelect');
            const nextVaccinationContainer = document.getElementById('nextVaccinationContainer');
            const nextVaccinationText = document.getElementById('nextVaccination');

            // Handle appointment type change
            appointmentTypeSelect.addEventListener('change', function() {
                if (this.value === 'vaccination') {
                    vaccinationTypeContainer.style.display = 'block';
                    vaccinationTypeSelect.setAttribute('required', '');
                    updateNextVaccination();
                } else {
                    vaccinationTypeContainer.style.display = 'none';
                    vaccinationTypeSelect.removeAttribute('required');
                    nextVaccinationContainer.style.display = 'none';
                    nextVaccinationText.textContent = '';
                }
            });

            // Handle patient selection change
            patientSelect.addEventListener('change', function() {
                if (appointmentTypeSelect.value === 'vaccination' && this.selectedOptions[0]?.dataset
                    .type === 'baby') {
                    updateNextVaccination();
                } else {
                    nextVaccinationContainer.style.display = 'none';
                    nextVaccinationText.textContent = '';
                }
            });

            // Function to fetch and update next vaccination
            function updateNextVaccination() {
                const patientId = patientSelect.value;
                const patientType = patientSelect.selectedOptions[0]?.dataset.type;

                if (!patientId || patientType !== 'baby' || appointmentTypeSelect.value !== 'vaccination') {
                    nextVaccinationContainer.style.display = 'none';
                    nextVaccinationText.textContent = '';
                    vaccinationTypeSelect.value = '';
                    return;
                }

                fetch(`/babies/${patientId}/next-vaccination`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        nextVaccinationContainer.style.display = 'block';
                        if (data.nextVaccination) {
                            nextVaccinationText.textContent = `Next: ${data.nextVaccinationDisplay}`;
                            vaccinationTypeSelect.value = data
                            .nextVaccination; // Preselect the next vaccination
                        } else {
                            nextVaccinationText.textContent = 'No further vaccinations scheduled';
                            vaccinationTypeSelect.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching next vaccination:', error);
                        nextVaccinationContainer.style.display = 'block';
                        nextVaccinationText.textContent = 'Error loading next vaccination';
                        vaccinationTypeSelect.value = '';
                    });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[id^="rescheduleType"]').forEach(select => {
            select.addEventListener('change', function() {
                const modalId = this.id.replace('rescheduleType', '');
                const vaccinationContainer = document.getElementById(`vaccinationTypeContainer${modalId}`);
                if (this.value === 'vaccination') {
                    vaccinationContainer.style.display = 'block';
                    document.getElementById(`rescheduleVaccinationType${modalId}`).setAttribute('required',
                        '');
                } else {
                    vaccinationContainer.style.display = 'none';
                    document.getElementById(`rescheduleVaccinationType${modalId}`).removeAttribute(
                        'required');
                }
            });
        });
    </script>
    <script>
        // Calendar month navigation
        document.addEventListener('DOMContentLoaded', function() {
            const calendarMonthEl = document.getElementById('calendarMonth');
            const calendarGridEl = document.getElementById('calendarGrid');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const todayMonthBtn = document.getElementById('todayMonth');
            let currentMonth = '{{ $calendarMonth->format('Y-m') }}';

            // Debug: Confirm initial setup
            console.log('Calendar initialized:', {
                calendarMonthEl: !!calendarMonthEl,
                calendarGridEl: !!calendarGridEl,
                prevMonthBtn: !!prevMonthBtn,
                nextMonthBtn: !!nextMonthBtn,
                todayMonthBtn: !!todayMonthBtn,
                initialMonth: currentMonth
            });

            function loadCalendar(month) {
                console.log('Loading calendar for month:', month);
                fetch(`/appointments/calendar?month=${month}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => {
                        console.log('Fetch response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received calendar data:', {
                            month: data.month,
                            month_key: data.month_key,
                            dayCount: Object.keys(data.days).length,
                            appointmentCount: Object.values(data.days).reduce((sum, day) => sum + day
                                .appointments.length, 0)
                        });

                        // Update month display
                        calendarMonthEl.textContent = data.month;
                        currentMonth = data.month_key;

                        // Clear existing calendar
                        calendarGridEl.innerHTML = '';

                        // Generate new calendar days
                        Object.keys(data.days).forEach(date => {
                            const dayData = data.days[date];
                            const dayEl = document.createElement('div');
                            dayEl.className =
                                `calendar-day ${dayData.isToday ? 'today' : ''} ${!dayData.isCurrentMonth ? 'text-muted' : ''}`;
                            dayEl.dataset.date = date;

                            // Day number
                            const dayNumberEl = document.createElement('div');
                            dayNumberEl.className = 'day-number';
                            dayNumberEl.textContent = dayData.day;
                            dayEl.appendChild(dayNumberEl);

                            // Appointments
                            dayData.appointments.forEach(appointment => {
                                const badgeEl = document.createElement('span');
                                badgeEl.className = `appointment-badge ${appointment.type}`;
                                badgeEl.title =
                                    `${appointment.patient_name} ${appointment.type.charAt(0).toUpperCase() + appointment.type.slice(1)} (${appointment.time})`;
                                badgeEl.textContent =
                                    `(${appointment.patient_type === 'baby' ? 'B' : 'PW'}-${appointment.patient_id}) ${appointment.type.charAt(0).toUpperCase() + appointment.type.slice(1)}`;
                                dayEl.appendChild(badgeEl);
                            });

                            calendarGridEl.appendChild(dayEl);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading calendar:', error);
                        alert('Failed to load calendar. Please check the console and try again.');
                    });
            }

            // Previous month
            if (prevMonthBtn) {
                prevMonthBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Previous month clicked, current:', currentMonth);
                    try {
                        const [year, month] = currentMonth.split('-').map(Number);
                        const date = new Date(year, month - 1, 1); // month is 0-based in JS
                        date.setMonth(date.getMonth() - 1);
                        const newMonth =
                            `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`; // YYYY-MM
                        console.log('Navigating to previous month:', newMonth);
                        loadCalendar(newMonth);
                    } catch (err) {
                        console.error('Error calculating previous month:', err);
                    }
                });
            } else {
                console.error('Previous month button not found');
            }

            // Next month
            if (nextMonthBtn) {
                nextMonthBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Next month clicked, current:', currentMonth);
                    try {
                        const [year, month] = currentMonth.split('-').map(Number);
                        const date = new Date(year, month - 1, 1); // month is 0-based in JS
                        date.setMonth(date.getMonth() + 1);
                        const newMonth =
                            `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`; // YYYY-MM
                        console.log('Navigating to next month:', newMonth);
                        loadCalendar(newMonth);
                    } catch (err) {
                        console.error('Error calculating next month:', err);
                    }
                });
            } else {
                console.error('Next month button not found');
            }

            // Today
            if (todayMonthBtn) {
                todayMonthBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Today button clicked');
                    const today = new Date();
                    const newMonth = today.toISOString().slice(0, 7); // YYYY-MM
                    console.log('Navigating to current month:', newMonth);
                    loadCalendar(newMonth);
                });
            } else {
                console.error('Today month button not found');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle Complete and Missed button clicks
            function updateAppointmentStatus(appointmentId, status) {
                fetch(`/appointments/${appointmentId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            status: status
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const row = document.querySelector(`tr[data-appointment-id="${appointmentId}"]`);
                            if (row) {
                                const statusCell = row.querySelector('td:nth-child(6) span');
                                const actionCell = row.querySelector('.action-buttons');
                                statusCell.className = `status-badge status-${data.appointment.status}`;
                                statusCell.textContent = data.appointment.status_ucfirst;

                                if (data.appointment.status === 'completed' || data.appointment.status ===
                                    'missed') {
                                    actionCell.innerHTML = '';
                                }
                            }
                            console.log(`Appointment ${appointmentId} updated to ${status}`);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating appointment status:', error);
                        alert('Failed to update appointment status. Please try again.');
                    });
            }

            // Complete button handler
            document.querySelectorAll('.complete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const appointmentId = this.dataset.appointmentId;
                    updateAppointmentStatus(appointmentId, 'completed');
                });
            });

            // Missed button handler
            document.querySelectorAll('.missed-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const appointmentId = this.dataset.appointmentId;
                    updateAppointmentStatus(appointmentId, 'missed');
                });
            });

            // Check for past-due appointments every minute
            function checkPastDueAppointments() {
                const now = new Date();
                document.querySelectorAll('#todayAppointmentsBody tr').forEach(row => {
                    const appointmentId = row.dataset.appointmentId;
                    const timeCell = row.querySelector('td:first-child').textContent;
                    const statusCell = row.querySelector('td:nth-child(6) span');
                    const actionCell = row.querySelector('.action-buttons');

                    if (statusCell.textContent.toLowerCase() === 'scheduled') {
                        const appointmentTime = new Date(`${now.toDateString()} ${timeCell}`);
                        if (now > appointmentTime) {
                            updateAppointmentStatus(appointmentId, 'missed');
                        }
                    }
                });
            }

            // Run check immediately and every minute
            checkPastDueAppointments();
            setInterval(checkPastDueAppointments, 60000);

            // Update search to handle new buttons
            const originalSearchScript = document.querySelector('script[src*="searchAppointments"]');
            if (!originalSearchScript) {
                const searchInput = document.querySelector('.search-box input');
                const searchButton = document.getElementById('searchButton');
                const todayTableBody = document.getElementById('todayAppointmentsBody');
                const upcomingTableBody = document.getElementById('upcomingAppointmentsBody');

                function searchAppointments() {
                    const query = searchInput.value.trim();
                    if (!query) {
                        location.reload();
                        return;
                    }

                    fetch(`/appointments/search?query=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            todayTableBody.innerHTML = data.todayAppointments.length > 0 ?
                                data.todayAppointments
                                .map(appointment => `
                            <tr data-appointment-id="${appointment.id}">
                                <td>${appointment.time_formatted}</td>
                                <td class="patient-name">${appointment.patient_name || `<span class="text-danger">Invalid Patient (${appointment.patient_type}-${appointment.patient_id})</span>`}</td>
                                <td>${appointment.patient_age || '<span class="text-danger">N/A</span>'}</td>
                                <td>${appointment.patient_type_ucfirst}</td>
                                <td>${appointment.purpose}</td>
                                <td><span class="status-badge status-${appointment.status}">${appointment.status_ucfirst}</span></td>
                                <td class="action-buttons">
                                    ${
                                        appointment.status === 'scheduled' && !appointment.has_clinic_record
                                            ? `
                                                                                                    <button type="button" class="btn btn-outline-primary btn-sm action-btn clinic-btn" title="Enter Clinic Details" data-bs-toggle="modal" data-bs-target="#clinicRecordModal${appointment.id}">
                                                                                                        <i class="fas fa-clipboard"></i>
                                                                                                    </button>
                                                                                                    <button type="button" class="btn btn-outline-warning btn-sm action-btn reschedule-btn" title="Reschedule" data-bs-toggle="modal" data-bs-target="#rescheduleModal${appointment.id}">
                                                                                                        <i class="fas fa-calendar-alt"></i>
                                                                                                    </button>
                                                                                                    <button type="button" class="btn btn-outline-danger btn-sm action-btn missed-btn" title="Mark as Missed" data-appointment-id="${appointment.id}">
                                                                                                        <i class="fas fa-times"></i>
                                                                                                    </button>
                                                                                                `
                                            : appointment.has_clinic_record && appointment.status !== 'completed'
                                            ? `
                                                                                                    <button type="button" class="btn btn-success btn-sm action-btn complete-btn" title="Mark as Complete" data-appointment-id="${appointment.id}">
                                                                                                        <i class="fas fa-check"></i>
                                                                                                    </button>
                                                                                                `
                                            : ''
                                    }
                                </td>
                            </tr>
                        `)
                                .join('') :
                                '<tr><td colspan="7" class="text-center text-muted">No appointments for today.</td></tr>';

                            upcomingTableBody.innerHTML = data.upcomingAppointments.length > 0 ?
                                data.upcomingAppointments
                                .map(appointment => `
                            <tr>
                                <td>${appointment.date_time_formatted}</td>
                                <td class="patient-name">${appointment.patient_name || `<span class="text-danger">Invalid Patient (${appointment.patient_type}-${appointment.patient_id})</span>`}</td>
                                <td>${appointment.patient_age || '<span class="text-danger">N/A</span>'}</td>
                                <td>${appointment.patient_type_ucfirst}</td>
                                <td>${appointment.purpose}</td>
                                <td><span class="status-badge status-${appointment.status}">${appointment.status_ucfirst}</span></td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary btn-sm action-btn" title="View" data-bs-toggle="modal" data-bs-target="#viewModal${appointment.id}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    ${appointment.status !== 'completed' ? `
                                                                                            <button type="button" class="btn btn-outline-warning btn-sm action-btn" title="Reschedule" data-bs-toggle="modal" data-bs-target="#rescheduleModal${appointment.id}">
                                                                                                <i class="fas fa-calendar-alt"></i>
                                                                                            </button>` : ''}
                                </td>
                            </tr>
                        `)
                                .join('') :
                                '<tr><td colspan="7" class="text-center text-muted">No upcoming appointments.</td></tr>';

                            // Reattach event listeners for new buttons
                            document.querySelectorAll('.complete-btn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const appointmentId = this.dataset.appointmentId;
                                    updateAppointmentStatus(appointmentId, 'completed');
                                });
                            });
                            document.querySelectorAll('.missed-btn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const appointmentId = this.dataset.appointmentId;
                                    updateAppointmentStatus(appointmentId, 'missed');
                                });
                            });
                        })
                        .catch(error => console.error('Error fetching search results:', error));
                }

                searchButton.addEventListener('click', searchAppointments);
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchAppointments();
                    }
                });
            }
        });
    </script>
    <script>
        // Mobile menu functionality
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const mainContent = document.getElementById("mainContent");

        menuToggle?.addEventListener("click", function(e) {
            e.stopPropagation();
            sidebar.classList.toggle("show");
            overlay.style.display = "block";
        });

        overlay.addEventListener("click", function() {
            sidebar.classList.remove("show");
            overlay.style.display = "none";
        });

        document.querySelectorAll(".sidebar .nav-link").forEach((link) => {
            link.addEventListener("click", function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove("show");
                    overlay.style.display = "none";
                }
            });
        });

        window.addEventListener("resize", function() {
            if (window.innerWidth > 768) {
                overlay.style.display = "none";
            }
        });

        // Toggle between views
        document.getElementById("upcoming-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("history-tab").classList.remove("active");
            document.getElementById("calendar-tab").classList.remove("active");
            document.getElementById("upcomingView").classList.remove("d-none");
            document.getElementById("historyView").classList.add("d-none");
            document.getElementById("calendarView").classList.add("d-none");
        });

        document.getElementById("history-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("upcoming-tab").classList.remove("active");
            document.getElementById("calendar-tab").classList.remove("active");
            document.getElementById("historyView").classList.remove("d-none");
            document.getElementById("upcomingView").classList.add("d-none");
            document.getElementById("calendarView").classList.add("d-none");
        });

        document.getElementById("calendar-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("upcoming-tab").classList.remove("active");
            document.getElementById("history-tab").classList.remove("active");
            document.getElementById("calendarView").classList.remove("d-none");
            document.getElementById("upcomingView").classList.add("d-none");
            document.getElementById("historyView").classList.add("d-none");
        });

        // Dynamic patient select
        document.getElementById("appointmentPatientType").addEventListener("change", function() {
            const patientSelect = document.getElementById("patientSelect");
            const options = patientSelect.querySelectorAll("option");
            const selectedType = this.value;

            options.forEach(option => {
                if (option.value === "" || option.getAttribute("data-type") === selectedType) {
                    option.style.display = "block";
                } else {
                    option.style.display = "none";
                }
            });
            patientSelect.value = "";
        });

        // Vaccination type visibility
        document.getElementById("appointmentType").addEventListener("change", function() {
            const vaccinationContainer = document.getElementById("vaccinationTypeContainer");
            if (this.value === "vaccination") {
                vaccinationContainer.style.display = "block";
                document.getElementById("vaccinationType").setAttribute("required", "");
            } else {
                vaccinationContainer.style.display = "none";
                document.getElementById("vaccinationType").removeAttribute("required");
            }
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll("[title]"));
        tooltipTriggerList.forEach(tooltipTriggerEl => {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Set default date and time
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const dateStr = today.toISOString().split("T")[0];
            document.getElementById("appointmentDate").value = dateStr;

            const nextHour = today.getHours() + 1;
            const timeStr = (nextHour < 10 ? "0" : "") + nextHour + ":00";
            document.getElementById("appointmentTime").value = timeStr;
        });
    </script>
    <script>
        // Store patient data in JavaScript
        const patients = {
            baby: [
                @foreach ($babies as $baby)
                    {
                        id: {{ $baby->id }},
                        name: "{{ $baby->name }} (B-{{ $baby->id }})"
                    },
                @endforeach
            ],
            pregnant: [
                @foreach ($pregnantWomen as $pregnantWoman)
                    {
                        id: {{ $pregnantWoman->id }},
                        name: "{{ $pregnantWoman->name }} (PW-{{ $pregnantWoman->id }})"
                    },
                @endforeach
            ]
        };

        // Dynamic patient select
        document.getElementById("appointmentPatientType").addEventListener("change", function() {
            const patientSelect = document.getElementById("patientSelect");
            const selectedType = this.value;

            // Clear existing options except the default
            patientSelect.innerHTML = '<option value="">Select patient</option>';

            // Populate options based on selected type
            if (selectedType && patients[selectedType]) {
                patients[selectedType].forEach(patient => {
                    const option = document.createElement("option");
                    option.value = patient.id;
                    option.text = patient.name;
                    patientSelect.appendChild(option);
                });
            }
        });

        // Vaccination type visibility
        document.getElementById("appointmentType").addEventListener("change", function() {
            const vaccinationContainer = document.getElementById("vaccinationTypeContainer");
            const vaccinationType = document.getElementById("vaccinationType");
            if (this.value === "vaccination") {
                vaccinationContainer.style.display = "block";
                vaccinationType.setAttribute("required", "");
            } else {
                vaccinationContainer.style.display = "none";
                vaccinationType.removeAttribute("required");
            }
        });

        // Set default date and time
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const dateStr = today.toISOString().split("T")[0];
            document.getElementById("appointmentDate").value = dateStr;

            const nextHour = today.getHours() + 1;
            const timeStr = (nextHour < 10 ? "0" : "") + nextHour + ":00";
            document.getElementById("appointmentTime").value = timeStr;
        });
    </script>
</body>

</html>
