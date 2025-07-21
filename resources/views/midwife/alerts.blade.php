
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vaccination Alerts | Baby Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --teal: #2b7c85;
            --teal-dark: #175873;
            --teal-light: #87aca3;
            --navy: #0c1446;
            --gradient-start: #2b7c85;
            --gradient-end: #2b7c85;
            --primary-blue: #13646d;
            --secondary-blue: #4285f4;
            --light-blue: #e8f0fe;
            --dark-blue: #0c2d48;
            --accent-blue: #8ab4f8;
            --sidebar-width: 250px;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--primary-blue);
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

        .mobile-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue) 100%);
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

        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
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

        .content-area {
            padding: 25px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .alert-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border-left: 4px solid;
        }

        .alert-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-card.warning {
            border-left-color: #ffc107;
        }

        .alert-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .alert-title {
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0;
        }

        .alert-date {
            font-size: 13px;
            color: #6c757d;
        }

        .alert-patient {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .alert-message {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .alert-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending_age, .status-missed {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-resolved, .status-scheduled {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-left: 5px;
        }

        .arrow a {
            text-decoration: none;
        }

        @media (max-width: 992px) {
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
        }

        @media (max-width: 768px) {
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

            .alert-header {
                flex-direction: column;
            }

            .alert-date {
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header d-lg-none">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0">Vaccination Alerts</h5>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column p-3 text-white" style="height: 100%">
            <div class="text-center mb-4 mt-3 d-none d-lg-block">
                <img src="" class="rounded-circle mb-2 midphoto" alt="Profile" id="profileImage"
                    data-bs-toggle="modal" data-bs-target="#profileModal">
                <h5>{{ Auth::user()->name ?? 'Guest' }}</h5>
                <small class="text-white-50">Registered Midwife</small>
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('midwife.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.patients') }}" class="nav-link">
                        <i class="fas fa-baby"></i> My Patients
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.appointments') }}" class="nav-link">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </li>

                <li>
                    <a href="{{ route('thriposha.distribution') }}" class="nav-link">
                        <i class="fas fa-utensils"></i> Nutrition
                    </a>
                </li>
                <li>
                    <a href="{{ route('vaccination_alerts.index') }}" class="nav-link active">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-medical"></i> Reports
                    </a>
                </li>

            </ul>
            <div class="mt-auto">
                <a href="{{ route('admin.login.form') }}" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation Bar -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center arrow">
                        <a href="{{ route('midwife.dashboard') }}" class="back-btn me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0 d-none d-md-block text-white">Vaccination Alerts</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('vaccination_alerts.index') }}" method="GET" class="input-group search-box me-3">
                            <input type="text" name="search" class="form-control bg-transparent border-0" placeholder="Search alerts..." value="{{ request('search') }}" id="alertSearch">
                            <button class="btn search-btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Vaccination Alerts View -->
            <div id="vaccinationAlertsView">
                @forelse ($alerts as $alert)
                    <div class="alert-card warning" data-vaccination-id="{{ $alert['vaccination_id'] }}">
                        <div class="alert-header">
                            <h6 class="alert-title">{{ $alert['vaccine_name'] }} Vaccination Due</h6>
                            <div class="alert-date">{{ $alert['due_date']->format('l, h:i A') }}</div>
                        </div>
                        <div class="alert-patient">{{ $alert['baby_name'] }} (B-{{ $alert['baby_id'] }}) - {{ $alert['recommended_age'] }}</div>
                        <div class="alert-message">
                            {{ $alert['vaccine_name'] }} ({{ $alert['dose'] }}) is due on {{ $alert['due_date']->format('Y-m-d') }}. Please schedule or reschedule an appointment.
                        </div>
                        <div class="alert-actions">
                            <span class="alert-status status-{{ $alert['status'] }}">{{ ucfirst($alert['status']) }}</span>
                            <div>
                                <a href="{{ url('patients/' . $alert['baby_id']) }}" class="btn btn-sm btn-outline-primary action-btn" title="View Patient">
                                    <i class="fas fa-user"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-success action-btn mark-resolved" title="Mark as Resolved">
                                    <i class="fas fa-check"></i>
                                </button>
                                @if ($alert['appointment'])
                                    <button class="btn btn-sm btn-outline-warning action-btn reschedule-appointment" title="Reschedule Appointment" data-bs-toggle="modal" data-bs-target="#rescheduleAppointmentModal" data-appointment-id="{{ $alert['appointment']['id'] }}" data-appointment-date="{{ $alert['appointment']['date'] }}" data-appointment-time="{{ $alert['appointment']['time'] }}" data-appointment-notes="{{ $alert['appointment']['notes'] }}">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-info action-btn schedule-appointment" title="Schedule Appointment" data-bs-toggle="modal" data-bs-target="#scheduleAppointmentModal" data-vaccination-id="{{ $alert['vaccination_id'] }}">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No vaccination alerts for today or tomorrow.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Schedule Appointment Modal -->
    <div class="modal fade" id="scheduleAppointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus me-2"></i>Schedule Appointment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleAppointmentForm">
                        <input type="hidden" name="vaccination_id" id="appointmentVaccinationId">
                        <div class="mb-3">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" name="appointment_date" id="appointmentDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" name="appointment_time" id="appointmentTime" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="appointmentNotes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="scheduleAppointmentForm" class="btn btn-teal">Schedule</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reschedule Appointment Modal -->
    <div class="modal fade" id="rescheduleAppointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-alt me-2"></i>Reschedule Appointment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rescheduleAppointmentForm">
                        <input type="hidden" name="appointment_id" id="rescheduleAppointmentId">
                        <div class="mb-3">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" name="appointment_date" id="rescheduleAppointmentDate" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" name="appointment_time" id="rescheduleAppointmentTime" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="rescheduleAppointmentNotes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="rescheduleAppointmentForm" class="btn btn-teal">Reschedule</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const mainContent = document.getElementById("mainContent");

        menuToggle.addEventListener("click", function(e) {
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
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove("show");
                    overlay.style.display = "none";
                }
            });
        });

        window.addEventListener("resize", function() {
            if (window.innerWidth > 992) {
                overlay.style.display = "none";
            }
        });

        // Mark as Resolved
        document.querySelectorAll(".mark-resolved").forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const alertCard = this.closest(".alert-card");
                const vaccinationId = alertCard.dataset.vaccinationId;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch("{{ route('vaccination_alerts.resolve', ':vaccinationId') }}".replace(':vaccinationId', vaccinationId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alertCard.querySelector('.alert-status').textContent = 'Resolved';
                    alertCard.querySelector('.alert-status').classList.remove('status-pending_age', 'status-missed', 'status-scheduled');
                    alertCard.querySelector('.alert-status').classList.add('status-resolved');
                    alert(data.success);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while marking the alert as resolved.');
                });
            });
        });

        // Schedule Appointment
        document.querySelectorAll(".schedule-appointment").forEach(button => {
            button.addEventListener("click", function() {
                const vaccinationId = this.dataset.vaccinationId;
                document.getElementById("appointmentVaccinationId").value = vaccinationId;
                const dueDate = this.closest(".alert-card").querySelector(".alert-date").textContent;
                document.getElementById("appointmentDate").value = new Date(dueDate).toISOString().split('T')[0];
                document.getElementById("appointmentTime").value = new Date(dueDate).toTimeString().slice(0, 5);
            });
        });

        document.getElementById("scheduleAppointmentForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('vaccination_alerts.schedule') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const vaccinationId = formData.get('vaccination_id');
                const alertCard = document.querySelector(`.alert-card[data-vaccination-id="${vaccinationId}"]`);
                if (alertCard) {
                    alertCard.remove();
                }
                bootstrap.Modal.getInstance(document.getElementById("scheduleAppointmentModal")).hide();
                alert(data.success);
                this.reset();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while scheduling the appointment.');
            });
        });

        // Reschedule Appointment
        document.querySelectorAll(".reschedule-appointment").forEach(button => {
            button.addEventListener("click", function() {
                const appointmentId = this.dataset.appointmentId;
                const appointmentDate = this.dataset.appointmentDate;
                const appointmentTime = this.dataset.appointmentTime;
                const appointmentNotes = this.dataset.appointmentNotes;
                document.getElementById("rescheduleAppointmentId").value = appointmentId;
                document.getElementById("rescheduleAppointmentDate").value = appointmentDate;
                document.getElementById("rescheduleAppointmentTime").value = appointmentTime;
                document.getElementById("rescheduleAppointmentNotes").value = appointmentNotes || '';
            });
        });

        document.getElementById("rescheduleAppointmentForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('vaccination_alerts.reschedule') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const appointmentId = formData.get('appointment_id');
                const alertCard = document.querySelector(`.alert-card[data-appointment-id="${appointmentId}"]`) || this.closest('.alert-card');
                if (alertCard) {
                    alertCard.remove();
                }
                bootstrap.Modal.getInstance(document.getElementById("rescheduleAppointmentModal")).hide();
                alert(data.success);
                this.reset();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while rescheduling the appointment.');
            });
        });
    </script>
</body>
</html>

