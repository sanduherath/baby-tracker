<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Patient | Maternal-Child Health System</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link
        href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-blue: #13646d;
            --secondary-blue: #4285f4;
            --light-blue: #e8f0fe;
            --dark-blue: #0C2D48;
            --accent-blue: #8ab4f8;
            --pink-accent: #f06292;
            --baby-blue: #81d4fa;
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
            transition: all 0.3s;
            padding: 20px;
            min-height: 100vh;
        }

        /* Form Styles */
        .form-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background-color: white;
        }

        .form-header {
            background-color: var(--primary-blue);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .form-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        padding-bottom: 0px;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-section-title {
            color: var(--primary-blue);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .required-field::after {
            content: " *";
            color: red;
        }

        /* Patient Type Tabs */
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-blue);
            font-weight: 600;
            border-bottom: 3px solid var(--primary-blue);
        }

        .baby-tab {
            color: var(--baby-blue);
        }

        .pregnant-tab {
            color: var(--pink-accent);
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
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
                padding-top: 70px;
            }

            .nav-tabs .nav-link {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }

        .error-feedback::before {
            content: "⚠️ ";
            margin-right: 0.25rem;
        }

        .alert-success {
            border-left: 4px solid #28a745;
        }
    </style>
</head>

<body>
    <!-- Mobile Header -->
    <div class="mobile-header d-lg-none">
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0">Add New Patient</h5>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="d-flex flex-column p-3 text-white" style="height: 100%">
            <div class="text-center mb-4 mt-3 d-none d-lg-block">
                <img src="mid.jpeg" class="rounded-circle mb-2 midphoto" alt="Profile" id="profileImage"
                    data-bs-toggle="modal" data-bs-target="#profileModal" />
                <h5>{{ Auth::user()->midwife->name ?? 'Midwife Name' }}</h5>
                <small class="text-white-50">Registered Midwife</small>
            </div>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('midwife.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                 <li>
                    <a href="{{ route('midwife.patients') }}" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-baby"></i> My Patients
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.appointments') }}" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </li>

                <li>
                    <a href="Growth.html" class="nav-link">
                        <i class="fas fa-chart-line"></i> Growth Tracking
                    </a>
                </li>
                <li>
                    <a href="{{ route('thriposha.distribution') }}" class="nav-link">
                        <i class="fas fa-utensils"></i> Nutrition
                    </a>
                </li>
                <li>
                    <a href="alerts.html" class="nav-link">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="report.html" class="nav-link">
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
    <div class="main-content" id="mainContent">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Add New Patient</h1>
                <a href="{{ route('midwife.patients') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Patients
                </a>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card form-card">
                        <div class="card-header form-header">
                            <h5 class="mb-0 text-white"><i class="fas fa-user-plus me-2"></i> Patient Registration</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Please fix the following issues:</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <!-- Auto-close script -->
<script>
  // Auto close alerts after 6 seconds
  setTimeout(function () {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
      // Bootstrap 5 fade out
      alert.classList.remove('show');
      alert.classList.add('fade');
      setTimeout(() => alert.remove(), 300); // Remove from DOM after fade
    });
  }, 3000);
</script>
                            <!-- Patient Type Tabs -->
                            <ul class="nav nav-tabs mb-4" id="patientTypeTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="baby-tab" data-bs-toggle="tab"
                                        data-bs-target="#baby-tab-pane" type="button" role="tab">
                                        <i class="fas fa-baby me-1 baby-tab"></i> Newborn/Baby
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pregnant-tab" data-bs-toggle="tab"
                                        data-bs-target="#pregnant-tab-pane" type="button" role="tab">
                                        <i class="fas fa-female me-1 pregnant-tab"></i> Pregnant Woman
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="patientTypeTabsContent">
                                <!-- Baby Registration Form -->
                                <div class="tab-pane fade show active" id="baby-tab-pane" role="tabpanel"
                                    aria-labelledby="baby-tab">

                                    <form method="POST" action="{{ route('patients.storeBaby') }}" id="addBabyForm">
                                        @csrf
                                        <!-- Baby Information Section -->
                                        <div class="form-section">
                                            <h6 class="form-section-title"><i
                                                    class="fas fa-baby-carriage me-2 baby-tab"></i>Baby Information
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label for="baby_name" class="form-label required-field">Baby's
                                                        Full Name</label>
                                                    <input type="text"
                                                        class="form-control @error('baby_name') is-invalid @enderror"
                                                        id="baby_name" name="baby_name"
                                                        value="{{ old('baby_name') }}">
                                                    @error('baby_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="gender"
                                                        class="form-label required-field">Gender</label>
                                                    <select class="form-select @error('gender') is-invalid @enderror"
                                                        id="gender" name="gender">
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="male"
                                                            {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                                        </option>
                                                        <option value="female"
                                                            {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                                        </option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="birth_date" class="form-label required-field">Date of
                                                        Birth</label>
                                                    <input type="date"
                                                        class="form-control @error('birth_date') is-invalid @enderror"
                                                        id="birth_date" name="birth_date"
                                                        value="{{ old('birth_date') }}">
                                                    @error('birth_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="birth_weight" class="form-label required-field">Birth
                                                        Weight (kg)</label>
                                                    <input type="number" step="0.01"
                                                        class="form-control @error('birth_weight') is-invalid @enderror"
                                                        id="birth_weight" name="birth_weight"
                                                        value="{{ old('birth_weight') }}">
                                                    @error('birth_weight')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="birth_hospital" class="form-label">Place of
                                                        Birth</label>
                                                    <input type="text"
                                                        class="form-control @error('birth_hospital') is-invalid @enderror"
                                                        id="birth_hospital" name="birth_hospital"
                                                        value="{{ old('birth_hospital') }}"
                                                        placeholder="Hospital/Home">
                                                    @error('birth_hospital')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="delivery_type" class="form-label">Delivery
                                                        Type</label>
                                                    <select
                                                        class="form-select @error('delivery_type') is-invalid @enderror"
                                                        id="delivery_type" name="delivery_type">
                                                        <option value="" selected disabled>Select</option>
                                                        <option value="normal"
                                                            {{ old('delivery_type') == 'normal' ? 'selected' : '' }}>
                                                            Normal Vaginal Delivery</option>
                                                        <option value="cesarean"
                                                            {{ old('delivery_type') == 'cesarean' ? 'selected' : '' }}>
                                                            Cesarean Section</option>
                                                        <option value="assisted"
                                                            {{ old('delivery_type') == 'assisted' ? 'selected' : '' }}>
                                                            Assisted Vaginal Delivery</option>
                                                    </select>
                                                    @error('delivery_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="gestational_age" class="form-label">Gestational Age
                                                        (weeks)</label>
                                                    <input type="number"
                                                        class="form-control @error('gestational_age') is-invalid @enderror"
                                                        id="gestational_age" name="gestational_age" min="20"
                                                        max="45" value="{{ old('gestational_age') }}">
                                                    @error('gestational_age')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Parent Information Section -->
                                        <div class="form-section">
                                            <h6 class="form-section-title"><i class="fas fa-users me-2"></i>Parent
                                                Information</h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label for="mother_name"
                                                        class="form-label required-field">Mother's Full Name</label>
                                                    <input type="text"
                                                        class="form-control @error('mother_name') is-invalid @enderror"
                                                        id="mother_name" name="mother_name"
                                                        value="{{ old('mother_name') }}">
                                                    @error('mother_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="mother_nic" class="form-label required-field">Mother's
                                                        NIC</label>
                                                    <input type="text"
                                                        class="form-control @error('mother_nic') is-invalid @enderror"
                                                        id="mother_nic" name="mother_nic"
                                                        value="{{ old('mother_nic') }}">
                                                    @error('mother_nic')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="mother_contact"
                                                        class="form-label required-field">Mother's Contact</label>
                                                    <input type="tel"
                                                        class="form-control @error('mother_contact') is-invalid @enderror"
                                                        id="mother_contact" name="mother_contact"
                                                        value="{{ old('mother_contact') }}">
                                                    @error('mother_contact')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="father_name" class="form-label">Father's Full
                                                        Name</label>
                                                    <input type="text"
                                                        class="form-control @error('father_name') is-invalid @enderror"
                                                        id="father_name" name="father_name"
                                                        value="{{ old('father_name') }}">
                                                    @error('father_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="father_contact" class="form-label">Father's
                                                        Contact</label>
                                                    <input type="tel"
                                                        class="form-control @error('father_contact') is-invalid @enderror"
                                                        id="father_contact" name="father_contact"
                                                        value="{{ old('father_contact') }}">
                                                    @error('father_contact')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="mother_email"
                                                        class="form-label required-field">Parent's Email
                                                        Address</label>
                                                    <input type="email"
                                                        class="form-control @error('mother_email') is-invalid @enderror"
                                                        id="mother_email" name="mother_email"
                                                        value="{{ old('mother_email') }}"
                                                        placeholder="parent@example.com" required>
                                                    @error('mother_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="address"
                                                        class="form-label required-field">Address</label>
                                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="grama_niladhari_division"
                                                        class="form-label required-field">Grama Niladhari
                                                        Division</label>
                                                    <input type="text"
                                                        class="form-control @error('grama_niladhari_division') is-invalid @enderror"
                                                        id="grama_niladhari_division" name="grama_niladhari_division"
                                                        value="{{ old('grama_niladhari_division') }}">
                                                    @error('grama_niladhari_division')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="district"
                                                        class="form-label required-field">District</label>
                                                    <select
                                                        class="form-select @error('district') is-invalid @enderror"
                                                        id="district" name="district">
                                                        <option value="" selected disabled>Select District
                                                        </option>
                                                        <option value="colombo"
                                                            {{ old('district') == 'colombo' ? 'selected' : '' }}>
                                                            Colombo</option>
                                                        <option value="gampaha"
                                                            {{ old('district') == 'gampaha' ? 'selected' : '' }}>
                                                            Gampaha</option>
                                                        <option value="kalutara"
                                                            {{ old('district') == 'kalutara' ? 'selected' : '' }}>
                                                            Kalutara</option>
                                                        <option value="kandy"
                                                            {{ old('district') == 'kandy' ? 'selected' : '' }}>Kandy
                                                        </option>
                                                        <option value="matale"
                                                            {{ old('district') == 'matale' ? 'selected' : '' }}>Matale
                                                        </option>
                                                        <option value="nuwaraeliya"
                                                            {{ old('district') == 'nuwaraeliya' ? 'selected' : '' }}>
                                                            Nuwara Eliya</option>
                                                    </select>
                                                    @error('district')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="moh_area" class="form-label required-field">MOH
                                                        Area</label>
                                                    <input type="text"
                                                        class="form-control @error('moh_area') is-invalid @enderror"
                                                        id="moh_area" name="moh_area"
                                                        value="{{ old('moh_area') }}">
                                                    @error('moh_area')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Medical Information Section -->
                                        <div class="form-section">
                                            <h6 class="form-section-title"><i
                                                    class="fas fa-heartbeat me-2"></i>Medical Information</h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="birth_complications" class="form-label">Birth
                                                        Complications</label>
                                                    <textarea class="form-control @error('birth_complications') is-invalid @enderror" id="birth_complications"
                                                        name="birth_complications" rows="2" placeholder="If any">{{ old('birth_complications') }}</textarea>
                                                    @error('birth_complications')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="congenital_conditions" class="form-label">Congenital
                                                        Conditions</label>
                                                    <textarea class="form-control @error('congenital_conditions') is-invalid @enderror" id="congenital_conditions"
                                                        name="congenital_conditions" rows="2" placeholder="If any">{{ old('congenital_conditions') }}</textarea>
                                                    @error('congenital_conditions')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Initial Vaccinations Given</label>

                                                    <!-- BCG Vaccine -->
                                                    <div class="form-check">
                                                        <input type="hidden" name="bcg_vaccine" value="0">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="bcg_vaccine" name="bcg_vaccine" value="1"
                                                            {{ old('bcg_vaccine') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bcg_vaccine">BCG
                                                            Vaccine</label>
                                                    </div>

                                                    <!-- OPV 0 -->
                                                    <div class="form-check">
                                                        <input type="hidden" name="opv0_vaccine" value="0">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="opv0_vaccine" name="opv0_vaccine" value="1"
                                                            {{ old('opv0_vaccine') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="opv0_vaccine">OPV
                                                            0</label>
                                                    </div>

                                                    <!-- Hepatitis B -->
                                                    <div class="form-check">
                                                        <input type="hidden" name="hepb_vaccine" value="0">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="hepb_vaccine" name="hepb_vaccine" value="1"
                                                            {{ old('hepb_vaccine') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="hepb_vaccine">Hepatitis
                                                            B</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="additional_notes" class="form-label">Additional
                                                        Notes</label>
                                                    <textarea class="form-control @error('additional_notes') is-invalid @enderror" id="additional_notes"
                                                        name="additional_notes" rows="3">{{ old('additional_notes') }}</textarea>
                                                    @error('additional_notes')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                <div class="d-flex justify-content-end mt-4">
                                    <button type="reset" class="btn btn-outline-secondary me-3">
                                        <i class="fas fa-undo me-1"></i> Reset Form
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Save Baby Record
                                    </button>
                                </div>
                                </form>
                            </div>

                            <!-- Pregnant Woman Registration Form -->
                            <div class="tab-pane fade" id="pregnant-tab-pane" role="tabpanel"
                                aria-labelledby="pregnant-tab">
                                <form method="POST" action="{{ route('patients.storePregnantWoman') }}"
                                    id="addPregnantForm">
                                    @csrf
                                    <!-- Personal Information Section -->
                                    <div class="form-section">
                                        <h6 class="form-section-title"><i class="fas fa-user me-2"></i>Personal
                                            Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="pregnant_name" class="form-label required-field">Full
                                                    Name</label>
                                                <input type="text"
                                                    class="form-control @error('pregnant_name') is-invalid @enderror"
                                                    id="pregnant_name" name="pregnant_name"
                                                    value="{{ old('pregnant_name') }}">
                                                @error('pregnant_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_nic" class="form-label required-field">NIC
                                                    Number</label>
                                                <input type="text"
                                                    class="form-control @error('pregnant_nic') is-invalid @enderror"
                                                    id="pregnant_nic" name="pregnant_nic"
                                                    value="{{ old('pregnant_nic') }}">
                                                @error('pregnant_nic')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_dob" class="form-label required-field">Date
                                                    of Birth</label>
                                                <input type="date"
                                                    class="form-control @error('pregnant_dob') is-invalid @enderror"
                                                    id="pregnant_dob" name="pregnant_dob"
                                                    value="{{ old('pregnant_dob') }}">
                                                @error('pregnant_dob')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_contact"
                                                    class="form-label required-field">Contact Number</label>
                                                <input type="tel"
                                                    class="form-control @error('pregnant_contact') is-invalid @enderror"
                                                    id="pregnant_contact" name="pregnant_contact"
                                                    value="{{ old('pregnant_contact') }}">
                                                @error('pregnant_contact')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_email" class="form-label">Email
                                                    Address</label>
                                                <input type="email"
                                                    class="form-control @error('pregnant_email') is-invalid @enderror"
                                                    id="pregnant_email" name="pregnant_email"
                                                    value="{{ old('pregnant_email') }}">
                                                @error('pregnant_email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_occupation" class="form-label">Occupation</label>
                                                <input type="text"
                                                    class="form-control @error('pregnant_occupation') is-invalid @enderror"
                                                    id="pregnant_occupation" name="pregnant_occupation"
                                                    value="{{ old('pregnant_occupation') }}">
                                                @error('pregnant_occupation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pregnant_husband_name" class="form-label">Husband's
                                                    Name</label>
                                                <input type="text"
                                                    class="form-control @error('pregnant_husband_name') is-invalid @enderror"
                                                    id="pregnant_husband_name" name="pregnant_husband_name"
                                                    value="{{ old('pregnant_husband_name') }}">
                                                @error('pregnant_husband_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="pregnant_husband_contact" class="form-label">Husband's
                                                    Contact</label>
                                                <input type="tel"
                                                    class="form-control @error('pregnant_husband_contact') is-invalid @enderror"
                                                    id="pregnant_husband_contact" name="pregnant_husband_contact"
                                                    value="{{ old('pregnant_husband_contact') }}">
                                                @error('pregnant_husband_contact')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="pregnant_address"
                                                    class="form-label required-field">Address</label>
                                                <textarea class="form-control @error('pregnant_address') is-invalid @enderror" id="pregnant_address"
                                                    name="pregnant_address" rows="2">{{ old('pregnant_address') }}</textarea>
                                                @error('pregnant_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_gn_division"
                                                    class="form-label required-field">Grama Niladhari
                                                    Division</label>
                                                <input type="text"
                                                    class="form-control @error('pregnant_gn_division') is-invalid @enderror"
                                                    id="pregnant_gn_division" name="pregnant_gn_division"
                                                    value="{{ old('pregnant_gn_division') }}">
                                                @error('pregnant_gn_division')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_district"
                                                    class="form-label required-field">District</label>
                                                <select
                                                    class="form-select @error('pregnant_district') is-invalid @enderror"
                                                    id="pregnant_district" name="pregnant_district">
                                                    <option value="" selected disabled>Select District
                                                    </option>
                                                    <option value="colombo"
                                                        {{ old('pregnant_district') == 'colombo' ? 'selected' : '' }}>
                                                        Colombo</option>
                                                    <option value="gampaha"
                                                        {{ old('pregnant_district') == 'gampaha' ? 'selected' : '' }}>
                                                        Gampaha</option>
                                                    <option value="kalutara"
                                                        {{ old('pregnant_district') == 'kalutara' ? 'selected' : '' }}>
                                                        Kalutara</option>
                                                    <option value="kandy"
                                                        {{ old('pregnant_district') == 'kandy' ? 'selected' : '' }}>
                                                        Kandy</option>
                                                    <option value="matale"
                                                        {{ old('pregnant_district') == 'matale' ? 'selected' : '' }}>
                                                        Matale</option>
                                                    <option value="nuwaraeliya"
                                                        {{ old('pregnant_district') == 'nuwaraeliya' ? 'selected' : '' }}>
                                                        Nuwara Eliya</option>
                                                </select>
                                                @error('pregnant_district')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="pregnant_moh_area" class="form-label required-field">MOH
                                                    Area</label>
                                                <input type="text"
                                                    class="form-control @error('pregnant_moh_area') is-invalid @enderror"
                                                    id="pregnant_moh_area" name="pregnant_moh_area"
                                                    value="{{ old('pregnant_moh_area') }}">
                                                @error('pregnant_moh_area')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pregnancy Information Section -->
                                    <div class="form-section">
                                        <h6 class="form-section-title"><i
                                                class="fas fa-baby me-2 pregnant-tab"></i>Pregnancy Information
                                        </h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="lmp_date" class="form-label required-field">Last
                                                    Menstrual Period (LMP)</label>
                                                <input type="date"
                                                    class="form-control @error('lmp_date') is-invalid @enderror"
                                                    id="lmp_date" name="lmp_date" value="{{ old('lmp_date') }}">
                                                @error('lmp_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="edd_date" class="form-label required-field">Estimated
                                                    Due Date</label>
                                                <input type="date"
                                                    class="form-control @error('edd_date') is-invalid @enderror"
                                                    id="edd_date" name="edd_date" value="{{ old('edd_date') }}">
                                                @error('edd_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="gravida" class="form-label required-field">Gravida
                                                    (Pregnancy #)</label>
                                                <input type="number"
                                                    class="form-control @error('gravida') is-invalid @enderror"
                                                    id="gravida" name="gravida" min="1"
                                                    value="{{ old('gravida') }}">
                                                @error('gravida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="para" class="form-label required-field">Para (Live
                                                    Births)</label>
                                                <input type="number"
                                                    class="form-control @error('para') is-invalid @enderror"
                                                    id="para" name="para" min="0"
                                                    value="{{ old('para') }}">
                                                @error('para')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="abortions"
                                                    class="form-label">Abortions/Miscarriages</label>
                                                <input type="number"
                                                    class="form-control @error('abortions') is-invalid @enderror"
                                                    id="abortions" name="abortions" min="0"
                                                    value="{{ old('abortions') }}">
                                                @error('abortions')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="living_children" class="form-label">Living
                                                    Children</label>
                                                <input type="number"
                                                    class="form-control @error('living_children') is-invalid @enderror"
                                                    id="living_children" name="living_children" min="0"
                                                    value="{{ old('living_children') }}">
                                                @error('living_children')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="previous_complications" class="form-label">Previous
                                                    Pregnancy Complications</label>
                                                <textarea class="form-control @error('previous_complications') is-invalid @enderror" id="previous_complications"
                                                    name="previous_complications" rows="2" placeholder="If any">{{ old('previous_complications') }}</textarea>
                                                @error('previous_complications')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="current_complications" class="form-label">Current
                                                    Pregnancy Complications</label>
                                                <textarea class="form-control @error('current_complications') is-invalid @enderror" id="current_complications"
                                                    name="current_complications" rows="2" placeholder="If any">{{ old('current_complications') }}</textarea>
                                                @error('current_complications')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Medical History Section -->
                                    <div class="form-section">
                                        <h6 class="form-section-title"><i class="fas fa-medkit me-2"></i>Medical
                                            History</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Chronic Conditions (Check all that
                                                    apply)</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="diabetes" name="diabetes" value="1"
                                                                {{ old('diabetes') ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="diabetes">Diabetes</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="hypertension" name="hypertension" value="1"
                                                                {{ old('hypertension') ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="hypertension">Hypertension</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="asthma" name="asthma" value="1"
                                                                {{ old('asthma') ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="asthma">Asthma</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="heart_disease" name="heart_disease"
                                                                value="1"
                                                                {{ old('heart_disease') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="heart_disease">Heart
                                                                Disease</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="thyroid" name="thyroid" value="1"
                                                                {{ old('thyroid') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="thyroid">Thyroid
                                                                Disorder</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="other_condition" name="other_condition"
                                                                value="1"
                                                                {{ old('other_condition') ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="other_condition">Other</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="other_medical_info" class="form-label">Other Medical
                                                    Information</label>
                                                <textarea class="form-control @error('other_medical_info') is-invalid @enderror" id="other_medical_info"
                                                    name="other_medical_info" rows="3" placeholder="Allergies, medications, etc.">{{ old('other_medical_info') }}</textarea>
                                                @error('other_medical_info')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="reset" class="btn btn-outline-secondary me-3">
                                            <i class="fas fa-undo me-1"></i> Reset Form
                                        </button>
                                        <button type="submit" class="btn btn-primary"
                                            style="background-color: var(--pink-accent); border-color: var(--pink-accent);">
                                            <i class="fas fa-save me-1"></i> Save Pregnancy Record
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu functionality
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
