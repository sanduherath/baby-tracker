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

        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }

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

        .menu-toggle {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            padding: 5px 10px;
        }

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
            background-color: #39d773;
            color: #38413c;
        }

        .status-missed {
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
        }

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
    </style>
</head>
<body>
    <script>
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 300);
            });
        }, 3000);
    </script>

    <div class="mobile-header d-lg-none">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0">Appointment Management</h5>
    </div>

    <div class="overlay" id="overlay"></div>

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
                    <a href="{{ route('midwife.dashboard') }}" class="nav-link"style="color:white">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.patients') }}" class="nav-link"style="color:white">
                        <i class="fas fa-baby"></i> My Patients
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.appointments') }}" class="nav-link active"style="color:white">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </li>
                <li>
                    <a href="{{ route('thriposha.distribution') }}" class="nav-link"style="color:white">
                        <i class="fas fa-utensils"></i> Nutrition
                    </a>
                </li>
                <li>
                    <a href="{{ route('vaccination_alerts.index') }}" class="nav-link"style="color:white">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link" style="color:white">
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

    <div class="main-content" id="mainContent">
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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="container-fluid py-4">
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

 <div id="upcomingView">
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
                    <th style="width: 10%">Actions</th>
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
                                                ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})</span>
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
                                    @if ($appointment->status === 'scheduled')
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm action-btn clinic-btn"
                                            title="Enter Clinic Details" data-bs-toggle="modal"
                                            data-bs-target="#clinicRecordModal{{ $appointment->id }}">
                                            <i class="fas fa-clipboard"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-outline-warning btn-sm action-btn reschedule-btn"
                                            title="Reschedule"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rescheduleModal"
                                            data-appointment-id="{{ $appointment->id }}"
                                            data-date="{{ $appointment->date }}"
                                            data-time="{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}"
                                            data-patient-type="{{ $appointment->patient_type }}"
                                            data-patient-id="{{ $appointment->patient_id }}"
                                            data-type="{{ $appointment->type }}"
                                            data-vaccination-type="{{ $appointment->vaccination_type ?? '' }}"
                                            data-notes="{{ $appointment->notes ?? '' }}"
                                            data-action="update">
                                            <i class="fas fa-calendar-alt"></i>
                                        </button>
                                    @elseif ($appointment->status === 'missed')
                                        <button type="button"
                                            class="btn btn-outline-warning btn-sm action-btn reschedule-btn"
                                            title="Reschedule Appointment"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rescheduleModal"
                                            data-appointment-id="{{ $appointment->id }}"
                                            data-date="{{ $appointment->date }}"
                                            data-time="{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}"
                                            data-patient-type="{{ $appointment->patient_type }}"
                                            data-patient-id="{{ $appointment->patient_id }}"
                                            data-type="{{ $appointment->type }}"
                                            data-vaccination-type="{{ $appointment->vaccination_type ?? '' }}"
                                            data-notes="{{ $appointment->notes ?? '' }}"
                                            data-action="update">
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
                                <label for="weight{{ $appointment->id }}" class="form-label">Weight (kg)</label>
                                <input type="number" class="form-control"
                                    id="weight{{ $appointment->id }}" name="weight" step="0.01"
                                    min="0" max="200">
                            </div>
                            <div class="mb-3">
                                <label for="height{{ $appointment->id }}" class="form-label">Height (cm)</label>
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
                                    </select>
                                </div>
                                <div class="mb-3" id="thriposhaPacketsContainer{{ $appointment->id }}"
                                    style="display: none;">
                                    <label for="thriposhaPackets{{ $appointment->id }}"
                                        class="form-label">Thriposha Packets</label>
                                    <select class="form-select"
                                        id="thriposhaPackets{{ $appointment->id }}"
                                        name="thriposha_packets">
                                        <option value="">Select number of packets</option>
                                        <option value="1">1 Packet</option>
                                        <option value="2">2 Packets</option>
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
    @endforeach

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

            document.querySelectorAll('[id^="clinicRecordModal"]').forEach(modal => {
                modal.addEventListener('show.bs.modal', function(event) {
                    const modalId = this.id.replace('clinicRecordModal', '');
                    const vaccinationSelect = document.getElementById(`vaccinationName${modalId}`);
                    if (vaccinationSelect) {
                        fetch(`/appointments/${modalId}/pending-vaccinations`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                vaccinationSelect.innerHTML =
                                    '<option value="">Select vaccination</option>';
                                if (data.vaccinations && data.vaccinations.length > 0) {
                                    data.vaccinations.forEach(vaccine => {
                                        const option = document.createElement('option');
                                        option.value = vaccine.vaccine_name;
                                        option.textContent = vaccine.display_name ||
                                            vaccine.vaccine_name.toUpperCase();
                                        vaccinationSelect.appendChild(option);
                                    });
                                } else {
                                    vaccinationSelect.innerHTML +=
                                        '<option value="" disabled>No pending or missed vaccinations</option>';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching pending vaccinations:', error);
                                vaccinationSelect.innerHTML +=
                                    '<option value="" disabled>Error loading vaccinations</option>';
                            });
                    }
                });
            });
        });
    </script>

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
                                                ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})</span>
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
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm action-btn"
                                        title="View" data-bs-toggle="modal"
                                        data-bs-target="#viewModal{{ $appointment->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if ($appointment->status === 'scheduled' || $appointment->status === 'missed')
                                        <button type="button"
                                            class="btn btn-outline-warning btn-sm action-btn reschedule-btn"
                                            title="Reschedule Appointment"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rescheduleModal"
                                            data-appointment-id="{{ $appointment->id }}"
                                            data-date="{{ $appointment->date }}"
                                            data-time="{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}"
                                            data-patient-type="{{ $appointment->patient_type }}"
                                            data-patient-id="{{ $appointment->patient_id }}"
                                            data-type="{{ $appointment->type }}"
                                            data-vaccination-type="{{ $appointment->vaccination_type ?? '' }}"
                                            data-notes="{{ $appointment->notes ?? '' }}"
                                            data-action="update">
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
                                            appointment.status === 'scheduled' ?
                                            `
                                            <button type="button" class="btn btn-outline-primary btn-sm action-btn clinic-btn" title="Enter Clinic Details" data-bs-toggle="modal" data-bs-target="#clinicRecordModal${appointment.id}">
                                                <i class="fas fa-clipboard"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-sm action-btn reschedule-btn" title="Reschedule" data-bs-toggle="modal" data-bs-target="#rescheduleModal"
                                                data-appointment-id="${appointment.id}"
                                                data-date="${appointment.date}"
                                                data-time="${appointment.time_formatted.split(' ')[0]}"
                                                data-patient-type="${appointment.patient_type}"
                                                data-patient-id="${appointment.patient_id}"
                                                data-type="${appointment.type}"
                                                data-vaccination-type="${appointment.vaccination_type || ''}"
                                                data-notes="${appointment.notes || ''}"
                                                data-action="update">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            ` : appointment.status === 'missed' ?
                                            `
                                            <button type="button" class="btn btn-outline-warning btn-sm action-btn reschedule-btn" title="Reschedule Appointment" data-bs-toggle="modal" data-bs-target="#rescheduleModal"
                                                data-appointment-id="${appointment.id}"
                                                data-date="${appointment.date}"
                                                data-time="${appointment.time_formatted.split(' ')[0]}"
                                                data-patient-type="${appointment.patient_type}"
                                                data-patient-id="${appointment.patient_id}"
                                                data-type="${appointment.type}"
                                                data-vaccination-type="${appointment.vaccination_type || ''}"
                                                data-notes="${appointment.notes || ''}"
                                                data-action="update">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            ` : ''
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
                                            appointment.status === 'scheduled' || appointment.status === 'missed' ?
                                            `
                                            <button type="button" class="btn btn-outline-warning btn-sm action-btn reschedule-btn" title="Reschedule Appointment" data-bs-toggle="modal" data-bs-target="#rescheduleModal"
                                                data-appointment-id="${appointment.id}"
                                                data-date="${appointment.date}"
                                                data-time="${appointment.time_formatted.split(' ')[0]}"
                                                data-patient-type="${appointment.patient_type}"
                                                data-patient-id="${appointment.patient_id}"
                                                data-type="${appointment.type}"
                                                data-vaccination-type="${appointment.vaccination_type || ''}"
                                                data-notes="${appointment.notes || ''}"
                                                data-action="update">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                            ` : ''
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
                                                    ({{ $appointment->patient_type }}-{{ $appointment->patient_id }})</span>
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
                            ({{ $appointment->patient_type === 'baby' ? 'B' : 'PW' }}-{{ $appointment->patient_id }}) {{ ucfirst($appointment->type) }}
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

<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-teal text-white">
                <h5 class="modal-title" id="rescheduleModalLabel">
                    <i class="fas fa-calendar-alt me-2"></i>Reschedule Appointment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rescheduleForm" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="rescheduleAppointmentId" name="appointment_id">
                    <input type="hidden" id="rescheduleAction" name="action" value="update">
                    <input type="hidden" id="rescheduleStatus" name="status" value="scheduled">
                    <div class="mb-3">
                        <label for="reschedulePatientType" class="form-label">Patient Type</label>
                        <select class="form-select" id="reschedulePatientType" name="patient_type" disabled>
                            <option value="">Select patient type</option>
                            <option value="baby">Baby</option>
                            <option value="pregnant">Pregnant Woman</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reschedulePatientId" class="form-label">Patient</label>
                        <select class="form-select" id="reschedulePatientId" name="patient_id" disabled>
                            <option value="">Select patient</option>
                            @foreach ($babies as $baby)
                                <option value="{{ $baby->id }}" data-type="baby">{{ $baby->name }} (B-{{ $baby->id }})</option>
                            @endforeach
                            @foreach ($pregnantWomen as $pregnantWoman)
                                <option value="{{ $pregnantWoman->id }}" data-type="pregnant">{{ $pregnantWoman->name }} (PW-{{ $pregnantWoman->id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="rescheduleDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="rescheduleDate" name="date" required
                                min="{{ now()->toDateString() }}" />
                        </div>
                        <div class="col-md-6">
                            <label for="rescheduleTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="rescheduleTime" name="time" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="rescheduleType" class="form-label">Appointment Type</label>
                        <select class="form-select" id="rescheduleType" name="type" required>
                            <option value="">Select type</option>
                            <option value="vaccination">Vaccination</option>
                            <option value="checkup">Health Checkup</option>
                            <option value="prenatal">Prenatal Checkup</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3" id="rescheduleVaccinationTypeContainer" style="display: none;">
                        <label for="rescheduleVaccinationType" class="form-label">Vaccination Type</label>
                        <select class="form-select" id="rescheduleVaccinationType" name="vaccination_type">
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
                    </div>
                    <div class="mb-3" id="rescheduleNextVaccinationContainer" style="display: none;">
                        <label class="form-label">Next Recommended Vaccination</label>
                        <p id="rescheduleNextVaccination" class="form-text text-muted"></p>
                    </div>
                    <div class="mb-3">
                        <label for="rescheduleNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="rescheduleNotes" name="notes" rows="3"></textarea>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const appointmentTypeSelect = document.getElementById('appointmentType');
        const vaccinationTypeContainer = document.getElementById('vaccinationTypeContainer');
        const vaccinationTypeSelect = document.getElementById('vaccinationType');
        const patientSelect = document.getElementById('patientSelect');
        const nextVaccinationContainer = document.getElementById('nextVaccinationContainer');
        const nextVaccinationText = document.getElementById('nextVaccination');

        const rescheduleModal = document.getElementById('rescheduleModal');
        const rescheduleForm = document.getElementById('rescheduleForm');
        const reschedulePatientType = document.getElementById('reschedulePatientType');
        const reschedulePatientId = document.getElementById('reschedulePatientId');
        const rescheduleDate = document.getElementById('rescheduleDate');
        const rescheduleTime = document.getElementById('rescheduleTime');
        const rescheduleType = document.getElementById('rescheduleType');
        const rescheduleVaccinationTypeContainer = document.getElementById('rescheduleVaccinationTypeContainer');
        const rescheduleVaccinationType = document.getElementById('rescheduleVaccinationType');
        const rescheduleNextVaccinationContainer = document.getElementById('rescheduleNextVaccinationContainer');
        const rescheduleNextVaccination = document.getElementById('rescheduleNextVaccination');
        const rescheduleNotes = document.getElementById('rescheduleNotes');
        const rescheduleAppointmentId = document.getElementById('rescheduleAppointmentId');
        const rescheduleAction = document.getElementById('rescheduleAction');

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

        patientSelect.addEventListener('change', function() {
            if (appointmentTypeSelect.value === 'vaccination' && this.selectedOptions[0]?.dataset
                .type === 'baby') {
                updateNextVaccination();
            } else {
                nextVaccinationContainer.style.display = 'none';
                nextVaccinationText.textContent = '';
            }
        });

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
                    vaccinationTypeSelect.value = data.nextVaccination;
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

        rescheduleModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const appointmentId = button.getAttribute('data-appointment-id');
            const date = button.getAttribute('data-date');
            const time = button.getAttribute('data-time');
            const patientType = button.getAttribute('data-patient-type');
            const patientId = button.getAttribute('data-patient-id');
            const type = button.getAttribute('data-type');
            const vaccinationType = button.getAttribute('data-vaccination-type');
            const notes = button.getAttribute('data-notes');
            const action = button.getAttribute('data-action');

            rescheduleAppointmentId.value = appointmentId;
            rescheduleAction.value = action;
            rescheduleForm.action = `/appointments/${appointmentId}/reschedule`;
            rescheduleForm.querySelector('input[name="_method"]').value = 'PATCH';
            reschedulePatientType.value = patientType;
            reschedulePatientId.value = patientId;
            rescheduleDate.value = date;
            rescheduleTime.value = time;
            rescheduleType.value = type;
            rescheduleNotes.value = notes;

            if (type === 'vaccination') {
                rescheduleVaccinationTypeContainer.style.display = 'block';
                rescheduleVaccinationType.setAttribute('required', '');
                rescheduleVaccinationType.value = vaccinationType;
                if (patientType === 'baby') {
                    fetch(`/babies/${patientId}/next-vaccination`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        rescheduleNextVaccinationContainer.style.display = 'block';
                        if (data.nextVaccination) {
                            rescheduleNextVaccination.textContent = `Next: ${data.nextVaccinationDisplay}`;
                            rescheduleVaccinationType.value = data.nextVaccination || vaccinationType;
                        } else {
                            rescheduleNextVaccination.textContent = 'No further vaccinations scheduled';
                            rescheduleVaccinationType.value = vaccinationType;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching next vaccination:', error);
                        rescheduleNextVaccinationContainer.style.display = 'block';
                        rescheduleNextVaccination.textContent = 'Error loading next vaccination';
                        rescheduleVaccinationType.value = vaccinationType;
                    });
                } else {
                    rescheduleNextVaccinationContainer.style.display = 'none';
                    rescheduleNextVaccination.textContent = '';
                }
            } else {
                rescheduleVaccinationTypeContainer.style.display = 'none';
                rescheduleVaccinationType.removeAttribute('required');
                rescheduleVaccinationType.value = '';
                rescheduleNextVaccinationContainer.style.display = 'none';
                rescheduleNextVaccination.textContent = '';
            }
        });

        rescheduleType.addEventListener('change', function() {
            if (this.value === 'vaccination') {
                rescheduleVaccinationTypeContainer.style.display = 'block';
                rescheduleVaccinationType.setAttribute('required', '');
                if (reschedulePatientType.value === 'baby') {
                    const patientId = reschedulePatientId.value;
                    fetch(`/babies/${patientId}/next-vaccination`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        rescheduleNextVaccinationContainer.style.display = 'block';
                        if (data.nextVaccination) {
                            rescheduleNextVaccination.textContent = `Next: ${data.nextVaccinationDisplay}`;
                            rescheduleVaccinationType.value = data.nextVaccination;
                        } else {
                            rescheduleNextVaccination.textContent = 'No further vaccinations scheduled';
                            rescheduleVaccinationType.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching next vaccination:', error);
                        rescheduleNextVaccinationContainer.style.display = 'block';
                        rescheduleNextVaccination.textContent = 'Error loading next vaccination';
                        rescheduleVaccinationType.value = '';
                    });
                }
            } else {
                rescheduleVaccinationTypeContainer.style.display = 'none';
                rescheduleVaccinationType.removeAttribute('required');
                rescheduleVaccinationType.value = '';
                rescheduleNextVaccinationContainer.style.display = 'none';
                rescheduleNextVaccination.textContent = '';
            }
        });

        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

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

        const calendarMonthEl = document.getElementById('calendarMonth');
        const calendarGridEl = document.getElementById('calendarGrid');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const todayMonthBtn = document.getElementById('todayMonth');
        let currentMonth = '{{ $calendarMonth->format('Y-m') }}';

        function loadCalendar(month) {
            fetch(`/appointments/calendar?month=${month}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                calendarMonthEl.textContent = data.month;
                currentMonth = data.month_key;
                calendarGridEl.innerHTML = '';

                Object.keys(data.days).forEach(date => {
                    const dayData = data.days[date];
                    const dayEl = document.createElement('div');
                    dayEl.className =
                        `calendar-day ${dayData.isToday ? 'today' : ''} ${!dayData.isCurrentMonth ? 'text-muted' : ''}`;
                    dayEl.dataset.date = date;

                    const dayNumberEl = document.createElement('div');
                    dayNumberEl.className = 'day-number';
                    dayNumberEl.textContent = dayData.day;
                    dayEl.appendChild(dayNumberEl);

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
                alert('Failed to load calendar. Please try again.');
            });
        }

        prevMonthBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const [year, month] = currentMonth.split('-').map(Number);
            const date = new Date(year, month - 1, 1);
            date.setMonth(date.getMonth() - 1);
            const newMonth =
                `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
            loadCalendar(newMonth);
        });

        nextMonthBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const [year, month] = currentMonth.split('-').map(Number);
            const date = new Date(year, month - 1, 1);
            date.setMonth(date.getMonth() + 1);
            const newMonth =
                `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
            loadCalendar(newMonth);
        });

        todayMonthBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const today = new Date();
            const newMonth = today.toISOString().slice(0, 7);
            loadCalendar(newMonth);
        });

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

        const tooltipTriggerList = [].slice.call(document.querySelectorAll("[title]"));
        tooltipTriggerList.forEach(tooltipTriggerEl => {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

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
