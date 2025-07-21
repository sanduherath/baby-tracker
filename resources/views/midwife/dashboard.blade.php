<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Midwife Dashboard | Baby Tracking System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --primary-blue: #13646d;
            --secondary-blue: #4285f4;
            --light-blue: #e8f0fe;
            --dark-blue: #0C2D48;
            --accent-blue: #8ab4f8;
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
            border-radius: 20px;
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
            padding: 20px;
            min-height: 100vh;
        }

        /* Cards */
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
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

        /* Badges */
        .thriposha-badge {
            background-color: #05a5fb;
            color: #202124;
            font-size: 0.75rem;
        }

        .vaccine-badge {
            background-color: #34a853;
            color: white;
        }

        .activity-item {
            border-left: 3px solid var(--primary-blue);
            padding-left: 10px;
            margin-bottom: 15px;
        }

        .activity-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Custom styles for vaccination and appointment cards */
        .vaccination-item,
        .appointment-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .vaccination-item:last-child,
        .appointment-item:last-child {
            border-bottom: none;
        }

        .vaccination-name {
            font-weight: bold;
            font-size: 1.1rem;
            color: var(--dark-blue);
        }

        .appointment-name {
            font-weight: bold;
            font-size: 1.1rem;
            color: var(--dark-blue);
        }

        .vaccination-details,
        .appointment-details {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 5px;
        }

        .vaccination-meta,
        .appointment-meta {
            font-size: 0.85rem;
            color: #777;
        }

        .due-date {
            display: inline-block;
            padding: 3px 8px;
            background-color: #6fcdcb;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .due-soon {
            background-color: #6fcdcb;
            color: #046133;
        }

        .due-tomorrow {
            background-color: #6fcdcb;
            color: #155724;
        }

        /* Profile Modal */
        .profile-modal .modal-header {
            background: linear-gradient(135deg,
                    var(--dark-blue) 0%,
                    var(--primary-blue) 100%);
            color: white;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin: -60px auto 20px;
            border: 5px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .c2 {
            padding-left: 100px;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .card-body {
                padding: 1rem;
            }

            .stats-card h4 {
                font-size: 1.5rem;
            }

            .stats-card i {
                font-size: 1.8rem;
            }
        }

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

            .stats-card h6 {
                font-size: 0.75rem;
            }

            .stats-card h4 {
                font-size: 1.3rem;
            }

            .stats-card i {
                font-size: 1.5rem;
            }

            .card-header h5 {
                font-size: 1.1rem;
            }

            .list-group-item {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
                padding-top: 70px;
            }

            .col-6 {
                padding-left: 5px;
                padding-right: 5px;
            }

            .stats-card {
                padding: 10px;
            }

            .stats-card h6 {
                font-size: 0.65rem;
                margin-bottom: 0.25rem;
            }

            .stats-card h4 {
                font-size: 1.1rem;
                margin-bottom: 0.25rem;
            }

            .stats-card i {
                font-size: 1.2rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .badge {
                font-size: 0.65rem;
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
        <h5 class="mb-0">Midwife Dashboard</h5>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column p-3 text-white" style="height: 100%">
            <div class="text-center mb-4 mt-3 d-none d-lg-block">
                <img src="Assests/mid.jpeg"class="rounded-circle mb-2 midphoto" alt="Profile" id="profileImage"
                    data-bs-toggle="modal" data-bs-target="#profileModal" />
                <h5>{{ Auth::user()->name }}</h5>
                <small class="text-white-50">Registered Midwife</small>
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="dash.html" class="nav-link active">
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
                    <a href="{{ route('vaccination_alerts.index') }}" class="nav-link">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link">
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
                <h1 class="h2 d-none d-lg-block">Public Health Midwife Dashboard </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">

                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-6 col-md-3 mb-3 ">
                    <div class="card h-100" style="background-color: #0c7d89; color: #ffffff;">
                        <div class="card-body stats-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase">Patients</h6>
                                    <h4 class="mb-0">10</h4>
                                </div>
                                <i class="fas fa-baby opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card h-100" style="background-color: #0c7d89; color: #ffffff;">
                        <div class="card-body stats-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase">Appointments</h6>
                                    <h4 class="mb-0">6</h4>
                                </div>
                                <i class="fas fa-calendar-check opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card h-100" style="background-color: #0c7d89; color: #ffffff;">
                        <div class="card-body stats-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase">Vaccinations</h6>
                                    <h4 class="mb-0">2</h4>
                                </div>
                                <i class="fas fa-syringe opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card h-100" style="background-color: #0c7d89; color: #ffffff;">
                        <div class="card-body stats-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase">Activities</h6>
                                    <h4 class="mb-0">6</h4>
                                </div>
                                <i class="fas fa-tasks opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Upcoming Vaccinations -->
                <div class="col-lg-6 mb-4 ">
                    <div class="card h-100 "style="background-color: #D6F0E8; color: #333;">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Upcoming Vaccinations</h5>
                        </div>
                        <div class="card-body">
                            <div class="vaccination-item">
                                <div class="vaccination-name">sandunika - MMR Vaccine</div>
                                <div class="vaccination-details">
                                    2nd dose | Last given: 3 months ago
                                </div>
                                <div class="vaccination-meta">
                                    Mother: kumari | Contact: 0752469722
                                </div>
                                <div class="due-date due-tomorrow">Due tomorrow</div>
                            </div>

                            <div class="vaccination-item">
                                <div class="vaccination-name">hasini ekanayake - Hepatitis B</div>
                                <div class="vaccination-details">
                                    3rd dose | Last given: 2 months ago
                                </div>
                                <div class="vaccination-meta">
                                    Mother: thamara | Contact: 0772549863
                                </div>
                                <div class="due-date due-soon">Due in 3 days</div>
                            </div>

                            <div class="vaccination-item">
                                <div class="vaccination-name">sara - DTaP</div>
                                <div class="vaccination-details">
                                    3rd dose | Last given: 4 months ago
                                </div>
                                <div class="vaccination-meta">
                                    Mother: akalanka wijerathne | Contact: 555-9012
                                </div>
                                <div class="due-date">Due in 5 days</div>
                            </div>

                            <a href="#" class="btn btn-outline-success w-100 mt-2">View All Vaccinations</a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Appointments -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 " style="background-color: #D6F0E8; color: #333;">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Upcoming Appointments</h5>
                        </div>
                        <div class="card-body">
                            <div class="appointment-item">
                                <div class="appointment-name">Kamala Herath</div>
                                <div class="appointment-details">Antenatal Checkup</div>
                                <div class="appointment-meta">
                                    <strong>Tomorrow 9:00 AM</strong> | At Home Visit
                                </div>
                            </div>

                            <div class="appointment-item">
                                <div class="appointment-name">Dinuka Herath</div>
                                <div class="appointment-details">4 Month Vaccination</div>
                                <div class="appointment-meta">
                                    <strong>12/06 10:30 AM</strong> | At Clinic
                                </div>
                            </div>

                            <div class="appointment-item">
                                <div class="appointment-name">Community Meeting</div>
                                <div class="appointment-details">Nutrition Awareness</div>
                                <div class="appointment-meta">
                                    <strong>14/06 2:00 PM</strong> | At Community Hall
                                </div>
                            </div>

                            <div class="appointment-item">
                                <div class="appointment-name">Thriposha Distribution</div>
                                <div class="appointment-details">Monthly Allocation</div>
                                <div class="appointment-meta">
                                    <strong>15/06 9:00 AM</strong> | At PHM Office
                                </div>
                            </div>

                            <a href="#" class="btn btn-outline-primary w-100 mt-2">View All Appointments</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="col-lg-12 mb-4">
                    <div class="card h-100" style="background-color: #D6F0E8; color: #333;">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Activities</h5>
                            <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Completed 2-month checkup for Emma Johnson</strong>
                                    <span class="activity-time">10:45 AM</span>
                                </div>
                                <p class="mb-1">
                                    Weight: 5.2kg, Height: 58cm. All parameters normal.
                                </p>
                                <small class="text-muted">Today</small>
                            </div>

                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Recorded Thriposha distribution for Aarav Patel</strong>
                                    <span class="activity-time">9:30 AM</span>
                                </div>
                                <p class="mb-1">Distributed 2 packets for 2 weeks.</p>
                                <small class="text-muted">Today</small>
                            </div>

                            <div class="activity-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Added new patient: Noah Williams</strong>
                                    <span class="activity-time">Yesterday</span>
                                </div>
                                <p class="mb-1">Mother: Jessica Williams, DOB: 15/05/2023</p>
                                <small class="text-muted">Yesterday, 4:20 PM</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Midwife Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body bg-dark text-light">
                    <div class="text-center">
                        <img src="mid.jpeg" class="rounded-circle profile-img" alt="Profile" />
                    </div>

                    <div class="row mb-4 c2">
                        <div class="col-md-6">
                            <h5>Personal Information</h5><br>
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>👉🏻 Full Name:</strong> Jane Doe</li>
                                <li class="mb-2">
                                    <strong>👉🏻 Registration No:</strong> MW-12345
                                </li>
                                <li class="mb-2"><strong>👉🏻 NIC:</strong> 123456789V</li>
                                <li class="mb-2">
                                    <strong>👉🏻 Date of Birth:</strong> 15/03/1985
                                </li>
                                <li class="mb-2">
                                    <strong>👉🏻 Contact:</strong> +94 77 123 4567
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Professional Information</h5><br>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>👉🏻 Clinic:</strong> Colombo Central Clinic
                                </li>
                                <li class="mb-2"><strong>👉🏻 Area:</strong> Colombo 05</li>

                                <li class="mb-2">
                                    <strong>👉🏻 Email:</strong> jane.doe@health.gov.lk
                                </li>
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

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced mobile menu functionality
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
        document.querySelectorAll(".sidebar .nav-link").forEach((link) => {
            link.addEventListener("click", function() {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove("show");
                    overlay.style.display = "none";
                }
            });
        });

        // Close sidebar when clicking outside (desktop)
        document.addEventListener("click", function(event) {
            if (window.innerWidth > 992 && !sidebar.contains(event.target)) {
                sidebar.classList.remove("show");
            }
        });

        // Adjust layout on resize
        window.addEventListener("resize", function() {
            if (window.innerWidth > 992) {
                overlay.style.display = "none";
            }
        });
    </script>
</body>

</html>
