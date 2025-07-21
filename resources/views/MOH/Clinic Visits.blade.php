<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Clinic Visits | MOH Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --primary-blue: #13646d;
            --secondary-blue: #4285f4;
            --light-blue: #e8f0fe;
            --dark-blue: #0c2d48;
            --accent-blue: #8ab4f8;
            --gradient-start: #13646d;
            --gradient-end: #0c2d48;
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
            background: linear-gradient(135deg,
                    var(--primary-blue) 0%,
                    var(--primary-blue) 100%);
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
            padding: 25px;
            transition: all 0.3s;
        }

        /* Dashboard Cards */
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: none;
            transition: all 0.3s;
            height: 100%;
            background-color: white;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        /* Mobile Header */
        .mobile-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(135deg,
                    var(--gradient-start),
                    var(--gradient-end));
            color: white;
            z-index: 900;
            display: none;
            align-items: center;
            padding: 0 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        /* Clinic Visits Table Styles */
        .visits-table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 25px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(19, 100, 109, 0.05);
        }

        .badge-pill {
            border-radius: 10px;
            padding: 5px 10px;
            font-weight: 500;
        }

        .status-completed {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-scheduled {
            background-color: rgba(13, 110, 253, 0.2);
            color: #0d6efd;
        }

        .status-cancelled {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .status-followup {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .action-btn {
            padding: 5px 10px;
            font-size: 0.8rem;
            margin-right: 5px;
        }

        .search-container {
            position: relative;
            margin-bottom: 20px;
        }

        .search-container .form-control {
            padding-left: 40px;
            border-radius: 20px;
        }

        .search-container i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }

        .filter-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 15px;
            margin-bottom: 20px;
        }

        /* Toggle buttons */
        .toggle-buttons {
            display: flex;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .toggle-btn {
            flex: 1;
            padding: 10px;
            text-align: center;
            background-color: #f8f9fa;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-btn.active {
            background-color: var(--primary-blue);
            color: white;
        }

        .toggle-btn:first-child {
            border-right: 1px solid #ddd;
        }

        /* Responsive Adjustments */
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
            .profile-circle {
                width: 36px;
                height: 36px;
                font-size: 14px;
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
        <h5 class="mb-0">Clinic Visits</h5>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column p-3 text-white" style="height: 100%">
            <div class="text-center mb-4 mt-3 d-none d-lg-block">
                <img src="moh.jpeg" class="rounded-circle mb-2 midphoto" alt="Profile" id="profileImage"
                    data-bs-toggle="modal" data-bs-target="#profileModal" />
                <h5>MOH Name</h5>
                <small class="text-white-50">Dr. Medical Officer</small>
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="Dashboard.html" class="nav-link">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="Patients.html" class="nav-link">
                        <i class="fas fa-baby"></i> My Patients
                    </a>
                </li>
                <li>
                    <a href="clinic.html" class="nav-link active">
                        <i class="fas fa-hospital-user"></i> Clinic Visits
                    </a>
                </li>
                <li>
                    <a href="vaccinations.html" class="nav-link">
                        <i class="fas fa-syringe"></i> Vaccinations
                    </a>
                </li>
                <li>
                    <a href="phm.html" class="nav-link">
                        <i class="fas fa-user-nurse"></i>PHM Management
                    </a>
                </li>
                <li>
                    <a href="nutrition.html" class="nav-link">
                        <i class="fas fa-utensils"></i> Nutrition
                    </a>
                </li>
                <li>
                    <a href="alerts.html" class="nav-link">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="reports.html" class="nav-link">
                        <i class="fas fa-file-medical"></i> Reports
                    </a>
                </li>
            </ul>
            <div class="mt-auto">
                <a href="#" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container-fluid">
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Clinic Visits</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addVisitModal">
                            <i class="fas fa-plus"></i> Schedule Visit
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-calendar-alt"></i> View Calendar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="dashboard-card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Today's Visits</h6>
                                <h3 class="mb-0">18</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-calendar-day text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">This Week</h6>
                                <h3 class="mb-0">42</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-calendar-week text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">High Priority</h6>
                                <h3 class="mb-0">5</h3>
                            </div>
                            <div class="bg-danger bg-opacity-10 p-3 rounded">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Follow-ups</h6>
                                <h3 class="mb-0">12</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-undo-alt text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-container mb-4">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="visitStatusFilter" class="form-label">Status</label>
                        <select class="form-select" id="visitStatusFilter">
                            <option value="">All Statuses</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="followup">Follow-up</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="visitTypeFilter" class="form-label">Visit Type</label>
                        <select class="form-select" id="visitTypeFilter">
                            <option value="">All Types</option>
                            <option value="routine">Routine Checkup</option>
                            <option value="vaccination">Vaccination</option>
                            <option value="emergency">Emergency</option>
                            <option value="followup">Follow-up</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="dateRangeFilter" class="form-label">Date Range</label>
                        <select class="form-select" id="dateRangeFilter">
                            <option value="">All Dates</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="phmFilter" class="form-label">PHM Area</label>
                        <select class="form-select" id="phmFilter">
                            <option value="">All Areas</option>
                            <option value="Colombo 01">Colombo 01</option>
                            <option value="Colombo 02">Colombo 02</option>
                            <option value="Colombo 03">Colombo 03</option>
                            <option value="Colombo 04">Colombo 04</option>
                            <option value="Colombo 05">Colombo 05</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Search and Stats -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="visitSearch"
                            placeholder="Search visits by patient name, ID, or reason..." />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-info p-2 mb-0 text-center">
                        <strong>Total Visits:</strong> 1,248 |
                        <strong>Completed:</strong> 1,102 | <strong>Scheduled:</strong> 146
                    </div>
                </div>
            </div>

            <!-- Visits Table -->
            <div class="visits-table-container">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Visit ID</th>
                                <th>Patient</th>
                                <th>Visit Type</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>PHM Area</th>
                                <th>Midwife</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>V-1042</td>
                                <td>
                                    <strong>Emma Johnson</strong>
                                    <div class="text-muted small">B-1042 | 3 months</div>
                                </td>
                                <td>Routine Checkup</td>
                                <td>
                                    <strong>15 Jun 2023</strong>
                                    <div class="text-muted small">10:30 AM</div>
                                </td>
                                <td>
                                    <span class="badge badge-pill status-completed">Completed</span>
                                </td>
                                <td>Colombo 05</td>
                                <td>N. Perera</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>V-1002</td>
                                <td>
                                    <strong>Liam Garcia</strong>
                                    <div class="text-muted small">B-1002 | 8 months</div>
                                </td>
                                <td>Vaccination</td>
                                <td>
                                    <strong>16 Jun 2023</strong>
                                    <div class="text-muted small">02:15 PM</div>
                                </td>
                                <td>
                                    <span class="badge badge-pill status-scheduled">Scheduled</span>
                                </td>
                                <td>Colombo 03</td>
                                <td>S. Fernando</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>V-1003</td>
                                <td>
                                    <strong>Sarah Johnson</strong>
                                    <div class="text-muted small">P-2042 | 28 years</div>
                                </td>
                                <td>Prenatal Checkup</td>
                                <td>
                                    <strong>17 Jun 2023</strong>
                                    <div class="text-muted small">09:00 AM</div>
                                </td>
                                <td>
                                    <span class="badge badge-pill status-followup">Follow-up</span>
                                </td>
                                <td>Colombo 05</td>
                                <td>N. Perera</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>V-1004</td>
                                <td>
                                    <strong>Aarav Patel</strong>
                                    <div class="text-muted small">B-1003 | 2 years</div>
                                </td>
                                <td>Emergency</td>
                                <td>
                                    <strong>12 Jun 2023</strong>
                                    <div class="text-muted small">04:45 PM</div>
                                </td>
                                <td>
                                    <span class="badge badge-pill status-completed">Completed</span>
                                </td>
                                <td>Colombo 07</td>
                                <td>R. Silva</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary action-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary action-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger action-btn">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Visit pagination">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Add Visit Modal -->
    <div class="modal fade" id="addVisitModal" tabindex="-1" aria-labelledby="addVisitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addVisitModalLabel">
                        Schedule New Clinic Visit
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="patientSelect" class="form-label">Patient</label>
                                <select class="form-select" id="patientSelect" required>
                                    <option value="">Select Patient</option>
                                    <option value="B-1042">Emma Johnson (B-1042)</option>
                                    <option value="B-1002">Liam Garcia (B-1002)</option>
                                    <option value="P-2042">Sarah Johnson (P-2042)</option>
                                    <option value="B-1003">Aarav Patel (B-1003)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="visitType" class="form-label">Visit Type</label>
                                <select class="form-select" id="visitType" required>
                                    <option value="">Select Visit Type</option>
                                    <option value="routine">Routine Checkup</option>
                                    <option value="vaccination">Vaccination</option>
                                    <option value="prenatal">Prenatal Checkup</option>
                                    <option value="emergency">Emergency</option>
                                    <option value="followup">Follow-up</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="visitDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="visitDate" required />
                            </div>
                            <div class="col-md-6">
                                <label for="visitTime" class="form-label">Time</label>
                                <input type="time" class="form-control" id="visitTime" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="assignedMidwife" class="form-label">Assigned Midwife</label>
                                <select class="form-select" id="assignedMidwife" required>
                                    <option value="">Select Midwife</option>
                                    <option value="N. Perera">N. Perera</option>
                                    <option value="S. Fernando">S. Fernando</option>
                                    <option value="R. Silva">R. Silva</option>
                                    <option value="L. Bandara">L. Bandara</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select" id="priority" required>
                                    <option value="normal">Normal</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="visitReason" class="form-label">Reason</label>
                            <textarea class="form-control" id="visitReason" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="visitNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="visitNotes" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary">
                        Schedule Visit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="profileModalLabel">MOH Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="moh.jpeg" class="rounded-circle profile-img" alt="Profile" />
                    </div>

                    <div class="row mb-4 c2">
                        <div class="col-md-6">
                            <h5>Personal Information</h5>
                            <br />
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>👉🏻 Full Name:</strong> Dr. Medical Officer
                                </li>
                                <li class="mb-2">
                                    <strong>👉🏻 Registration No:</strong> MOH-12345
                                </li>
                                <li class="mb-2"><strong>👉🏻 NIC:</strong> 123456789V</li>
                                <li class="mb-2">
                                    <strong>👉🏻 Date of Birth:</strong> 15/03/1975
                                </li>
                                <li class="mb-2">
                                    <strong>👉🏻 Contact:</strong> +94 77 123 4567
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Professional Information</h5>
                            <br />
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>👉🏻 MOH Area:</strong> Colombo District
                                </li>
                                <li class="mb-2">
                                    <strong>👉🏻 Hospital:</strong> Colombo General Hospital
                                </li>
                                <li class="mb-2">
                                    <strong>👉🏻 Email:</strong> moh.colombo@health.gov.lk
                                </li>
                                <li class="mb-2">
                                    <strong>👉🏻 Midwives Under Supervision:</strong> 24
                                </li>
                                <li class="mb-2"><strong>👉🏻 PHM Areas Covered:</strong> 8</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu functionality
        const menuToggle = document.getElementById("menuToggle");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const mainContent = document.getElementById("mainContent");
        const profileImage = document.getElementById("profileImage");

        menuToggle.addEventListener("click", function(e) {
            e.stopPropagation();
            sidebar.classList.toggle("show");
            overlay.style.display = "block";
        });

        overlay.addEventListener("click", function() {
            sidebar.classList.remove("show");
            overlay.style.display = "none";
        });

        // Close sidebar when clicking on a link
        document.querySelectorAll(".sidebar-menu li a").forEach((link) => {
            link.addEventListener("click", function() {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove("show");
                    overlay.style.display = "none";
                }
            });
        });

        // Simple search functionality
        document
            .getElementById("visitSearch")
            .addEventListener("keyup", function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll(".visits-table-container tbody tr");

                rows.forEach((row) => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });

        // Filter functionality
        document
            .getElementById("visitStatusFilter")
            .addEventListener("change", applyVisitFilters);
        document
            .getElementById("visitTypeFilter")
            .addEventListener("change", applyVisitFilters);
        document
            .getElementById("dateRangeFilter")
            .addEventListener("change", applyVisitFilters);
        document
            .getElementById("phmFilter")
            .addEventListener("change", applyVisitFilters);

        function applyVisitFilters() {
            const statusFilter = document.getElementById("visitStatusFilter").value;
            const typeFilter = document.getElementById("visitTypeFilter").value;
            const dateFilter = document.getElementById("dateRangeFilter").value;
            const phmFilter = document.getElementById("phmFilter").value;

            const rows = document.querySelectorAll(".visits-table-container tbody tr");

            rows.forEach((row) => {
                const status = row.querySelector(".badge").className.toLowerCase();
                const type = row.cells[2].textContent.toLowerCase();
                const date = row.cells[3].textContent.toLowerCase();
                const phm = row.cells[5].textContent.toLowerCase();

                const statusMatch = !statusFilter ||
                    (statusFilter === "scheduled" && status.includes("scheduled")) ||
                    (statusFilter === "completed" && status.includes("completed")) ||
                    (statusFilter === "cancelled" && status.includes("cancelled")) ||
                    (statusFilter === "followup" && status.includes("followup"));

                const typeMatch = !typeFilter ||
                    (typeFilter === "routine" && type.includes("routine")) ||
                    (typeFilter === "vaccination" && type.includes("vaccination")) ||
                    (typeFilter === "emergency" && type.includes("emergency")) ||
                    (typeFilter === "followup" && type.includes("followup"));

                const dateMatch = !dateFilter || true; // Date filtering would need more complex logic
                const phmMatch = !phmFilter || phm.includes(phmFilter.toLowerCase());

                if (statusMatch && typeMatch && dateMatch && phmMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>
