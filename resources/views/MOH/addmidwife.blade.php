<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Midwife | MOH Dashboard</title>
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

        /* Form Container */
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 25px;
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
            .form-container {
                padding: 20px;
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
        <h5 class="mb-0">Add Midwife</h5>
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
                    <a href="clinic.html" class="nav-link">
                        <i class="fas fa-hospital-user"></i> Clinic Visits
                    </a>
                </li>
                <li>
                    <a href="vaccinations.html" class="nav-link">
                        <i class="fas fa-syringe"></i> Vaccinations
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link active">
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
                <h1 class="h2">Add New Midwife</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="phm.html" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to PHM Management
                    </a>
                </div>
            </div>
@if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Please fix the following issues:</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
            <!-- Add Midwife Form -->
            <div class="form-container">
                <h4 class="mb-4">Midwife Registration</h4>
                <form id="addMidwifeForm" method="POST" action="{{ route('phm.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                id="full_name" name="full_name" value="{{ old('full_name') }}"
                                placeholder="Enter full name" required />
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nic" class="form-label">NIC Number</label>
                            <input type="text" class="form-control @error('nic') is-invalid @enderror" id="nic"
                                name="nic" value="{{ old('nic') }}" placeholder="Enter NIC number" required />
                            @error('nic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control @error('contact_number') is-invalid @enderror"
                                id="contact_number" name="contact_number" value="{{ old('contact_number') }}"
                                placeholder="Enter contact number" required />
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter email address" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phm_area" class="form-label">Assigned PHM Area</label>
                            <select class="form-select @error('phm_area') is-invalid @enderror" id="phm_area"
                                name="phm_area" required>
                                <option value="">Select PHM Area</option>
                                <option value="Colombo 01" {{ old('phm_area') == 'Colombo 01' ? 'selected' : '' }}>
                                    Colombo 01</option>
                                <option value="Colombo 02" {{ old('phm_area') == 'Colombo 02' ? 'selected' : '' }}>
                                    Colombo 02</option>
                                <option value="Colombo 03" {{ old('phm_area') == 'Colombo 03' ? 'selected' : '' }}>
                                    Colombo 03</option>
                                <option value="Colombo 04" {{ old('phm_area') == 'Colombo 04' ? 'selected' : '' }}>
                                    Colombo 04</option>
                                <option value="Colombo 05" {{ old('phm_area') == 'Colombo 05' ? 'selected' : '' }}>
                                    Colombo 05</option>
                            </select>
                            @error('phm_area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="registration_number" class="form-label">Registration Number</label>
                            <input type="text"
                                class="form-control @error('registration_number') is-invalid @enderror"
                                id="registration_number" name="registration_number"
                                value="{{ old('registration_number') }}" placeholder="Enter registration number"
                                required />
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start_date" name="start_date" value="{{ old('start_date') }}" required />
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="training_level" class="form-label">Training Level</label>
                            <select class="form-select @error('training_level') is-invalid @enderror"
                                id="training_level" name="training_level" required>
                                <option value="">Select Training Level</option>
                                <option value="basic" {{ old('training_level') == 'basic' ? 'selected' : '' }}>Basic
                                </option>
                                <option value="intermediate"
                                    {{ old('training_level') == 'intermediate' ? 'selected' : '' }}>Intermediate
                                </option>
                                <option value="advanced" {{ old('training_level') == 'advanced' ? 'selected' : '' }}>
                                    Advanced</option>
                            </select>
                            @error('training_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                            placeholder="Enter address" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                            placeholder="Enter any additional notes">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="active_status" name="active_status"
                            value="1" {{ old('active_status', 1) ? 'checked' : '' }} />
                        <label class="form-check-label" for="active_status">
                            Active Status
                        </label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('phm.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Register Midwife</button>
                    </div>
                </form>
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


    </script>
</body>

</html>
