<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Management | MOH Dashboard</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
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
        background: linear-gradient(
          135deg,
          var(--primary-blue) 0%,
          var(--primary-blue) 100%
        );
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
        background: linear-gradient(
          135deg,
          var(--gradient-start),
          var(--gradient-end)
        );
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

      /* Patient Table Styles */
      .patient-table-container {
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

      .status-active {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
      }

      .status-inactive {
        background-color: rgba(108, 117, 125, 0.2);
        color: #6c757d;
      }

      .status-high-risk {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
      }

      .status-warning {
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
      <h5 class="mb-0">Patient Management</h5>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div class="d-flex flex-column p-3 text-white" style="height: 100%">
        <div class="text-center mb-4 mt-3 d-none d-lg-block">
          <img
            src="moh.jpeg"
            class="rounded-circle mb-2 midphoto"
            alt="Profile"
            id="profileImage"
            data-bs-toggle="modal"
            data-bs-target="#profileModal"
          />
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
            <a href="Patients.html" class="nav-link active">
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
          class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
        >
          <h1 class="h2">Patient Management</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button
                type="button"
                class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addPatientModal"
              >
                <i class="fas fa-plus"></i> Add New Patient
              </button>
              <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-file-export"></i> Export Data
              </button>
            </div>
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
        <!-- Toggle Buttons -->
        <div class="toggle-buttons">
          <button class="toggle-btn active" id="showBabiesBtn">Babies</button>
          <button class="toggle-btn" id="showMothersBtn">
            Pregnant Mothers
          </button>
        </div>

        <!-- Filter Section -->
        <div class="filter-container mb-4">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="statusFilter" class="form-label">Status</label>
              <select class="form-select" id="statusFilter">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="high-risk">High Risk</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="ageFilter" class="form-label">Age Group</label>
              <select class="form-select" id="ageFilter">
                <option value="">All Ages</option>
                <option value="0-1">0-1 year</option>
                <option value="1-3">1-3 years</option>
                <option value="3-5">3-5 years</option>
                <option value="5+">5+ years</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="areaFilter" class="form-label">PHM Area</label>
              <select class="form-select" id="areaFilter">
                <option value="">All Areas</option>
                <option value="Colombo 01">Colombo 01</option>
                <option value="Colombo 02">Colombo 02</option>
                <option value="Colombo 03">Colombo 03</option>
                <option value="Colombo 04">Colombo 04</option>
                <option value="Colombo 05">Colombo 05</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="midwifeFilter" class="form-label">Midwife</label>
              <select class="form-select" id="midwifeFilter">
                <option value="">All Midwives</option>
                <option value="N. Perera">N. Perera</option>
                <option value="S. Fernando">S. Fernando</option>
                <option value="R. Silva">R. Silva</option>
                <option value="L. Bandara">L. Bandara</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Search and Stats -->
        <div class="row mb-4">
          <div class="col-md-8">
            <div class="search-container">
              <i class="fas fa-search"></i>
              <input
                type="text"
                class="form-control"
                id="patientSearch"
                placeholder="Search patients by name, ID, or mother's name..."
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="alert alert-info p-2 mb-0 text-center">
              <strong>Total Patients:</strong> 1,248 |
              <strong>Active:</strong> 1,102 | <strong>High Risk:</strong> 42
            </div>
          </div>
        </div>

        <!-- Baby Table -->
        <div class="patient-table-container" id="babyTable">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Patient ID</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Mother's Name</th>
                  <th>PHM Area</th>
                  <th>Midwife</th>
                  <th>Status</th>
                  <th>Last Visit</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>B-1042</td>
                  <td>
                    <strong>Emma Johnson</strong>
                    <div class="text-muted small">Female</div>
                  </td>
                  <td>3 months</td>
                  <td>Sarah Johnson</td>
                  <td>Colombo 05</td>
                  <td>N. Perera</td>
                  <td>
                    <span class="badge badge-pill status-active">Active</span>
                  </td>
                  <td>15 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger action-btn">
                      <i class="fas fa-flag"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>B-1002</td>
                  <td>
                    <strong>Liam Garcia</strong>
                    <div class="text-muted small">Male</div>
                  </td>
                  <td>8 months</td>
                  <td>Maria Garcia</td>
                  <td>Colombo 03</td>
                  <td>S. Fernando</td>
                  <td>
                    <span class="badge badge-pill status-high-risk"
                      >High Risk</span
                    >
                  </td>
                  <td>12 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger action-btn">
                      <i class="fas fa-flag"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>B-1003</td>
                  <td>
                    <strong>Aarav Patel</strong>
                    <div class="text-muted small">Male</div>
                  </td>
                  <td>2 years</td>
                  <td>Priya Patel</td>
                  <td>Colombo 07</td>
                  <td>R. Silva</td>
                  <td>
                    <span class="badge badge-pill status-warning"
                      >Vaccination Due</span
                    >
                  </td>
                  <td>10 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger action-btn">
                      <i class="fas fa-flag"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav aria-label="Patient pagination">
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

        <!-- Pregnant Mothers Table (Initially Hidden) -->
        <div
          class="patient-table-container"
          id="mothersTable"
          style="display: none"
        >
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Patient ID</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Weeks Pregnant</th>
                  <th>PHM Area</th>
                  <th>Midwife</th>
                  <th>Status</th>
                  <th>Last Visit</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>P-2042</td>
                  <td>
                    <strong>Sarah Johnson</strong>
                    <div class="text-muted small">Female</div>
                  </td>
                  <td>28 years</td>
                  <td>24 weeks</td>
                  <td>Colombo 05</td>
                  <td>N. Perera</td>
                  <td>
                    <span class="badge badge-pill status-active">Active</span>
                  </td>
                  <td>15 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger action-btn">
                      <i class="fas fa-flag"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>P-2002</td>
                  <td>
                    <strong>Maria Garcia</strong>
                    <div class="text-muted small">Female</div>
                  </td>
                  <td>32 years</td>
                  <td>36 weeks</td>
                  <td>Colombo 03</td>
                  <td>S. Fernando</td>
                  <td>
                    <span class="badge badge-pill status-high-risk"
                      >High Risk</span
                    >
                  </td>
                  <td>12 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger action-btn">
                      <i class="fas fa-flag"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>P-2003</td>
                  <td>
                    <strong>Priya Patel</strong>
                    <div class="text-muted small">Female</div>
                  </td>
                  <td>26 years</td>
                  <td>12 weeks</td>
                  <td>Colombo 07</td>
                  <td>R. Silva</td>
                  <td>
                    <span class="badge badge-pill status-warning"
                      >Checkup Due</span
                    >
                  </td>
                  <td>10 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger action-btn">
                      <i class="fas fa-flag"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav aria-label="Patient pagination">
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

    <!-- Add Patient Modal -->
    <div
      class="modal fade"
      id="addPatientModal"
      tabindex="-1"
      aria-labelledby="addPatientModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="addPatientModalLabel">
              Register New Patient
            </h5>
            <button
              type="button"
              class="btn-close btn-close-white"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="babyName" class="form-label">Baby's Name</label>
                  <input
                    type="text"
                    class="form-control"
                    id="babyName"
                    required
                  />
                </div>
                <div class="col-md-6">
                  <label for="gender" class="form-label">Gender</label>
                  <select class="form-select" id="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="dob" class="form-label">Date of Birth</label>
                  <input type="date" class="form-control" id="dob" required />
                </div>
                <div class="col-md-6">
                  <label for="birthWeight" class="form-label"
                    >Birth Weight (kg)</label
                  >
                  <input
                    type="number"
                    step="0.01"
                    class="form-control"
                    id="birthWeight"
                    required
                  />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="motherName" class="form-label"
                    >Mother's Name</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="motherName"
                    required
                  />
                </div>
                <div class="col-md-6">
                  <label for="motherNic" class="form-label"
                    >Mother's NIC Number</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="motherNic"
                    required
                  />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="contactNumber" class="form-label"
                    >Contact Number</label
                  >
                  <input
                    type="tel"
                    class="form-control"
                    id="contactNumber"
                    required
                  />
                </div>
                <div class="col-md-6">
                  <label for="address" class="form-label">Address</label>
                  <input
                    type="text"
                    class="form-control"
                    id="address"
                    required
                  />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="phmArea" class="form-label">PHM Area</label>
                  <select class="form-select" id="phmArea" required>
                    <option value="">Select PHM Area</option>
                    <option value="Colombo 01">Colombo 01</option>
                    <option value="Colombo 02">Colombo 02</option>
                    <option value="Colombo 03">Colombo 03</option>
                    <option value="Colombo 04">Colombo 04</option>
                    <option value="Colombo 05">Colombo 05</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="midwife" class="form-label"
                    >Assigned Midwife</label
                  >
                  <select class="form-select" id="midwife" required>
                    <option value="">Select Midwife</option>
                    <option value="N. Perera">N. Perera</option>
                    <option value="S. Fernando">S. Fernando</option>
                    <option value="R. Silva">R. Silva</option>
                    <option value="L. Bandara">L. Bandara</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="notes" class="form-label">Special Notes</label>
                <textarea class="form-control" id="notes" rows="3"></textarea>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="highRisk" />
                <label class="form-check-label" for="highRisk">
                  Mark as High Risk Case
                </label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Cancel
            </button>
            <button type="button" class="btn btn-primary">
              Register Patient
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Profile Modal (Same as dashboard) -->
    <div
      class="modal fade"
      id="profileModal"
      tabindex="-1"
      aria-labelledby="profileModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="profileModalLabel">MOH Profile</h5>
            <button
              type="button"
              class="btn-close btn-close-white"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="text-center">
              <img
                src="moh.jpeg"
                class="rounded-circle profile-img"
                alt="Profile"
              />
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
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
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

      menuToggle.addEventListener("click", function (e) {
        e.stopPropagation();
        sidebar.classList.toggle("show");
        overlay.style.display = "block";
      });

      overlay.addEventListener("click", function () {
        sidebar.classList.remove("show");
        overlay.style.display = "none";
      });

      // Close sidebar when clicking on a link
      document.querySelectorAll(".sidebar-menu li a").forEach((link) => {
        link.addEventListener("click", function () {
          if (window.innerWidth <= 992) {
            sidebar.classList.remove("show");
            overlay.style.display = "none";
          }
        });
      });

      // Toggle between baby and mother tables
      const showBabiesBtn = document.getElementById("showBabiesBtn");
      const showMothersBtn = document.getElementById("showMothersBtn");
      const babyTable = document.getElementById("babyTable");
      const mothersTable = document.getElementById("mothersTable");

      showBabiesBtn.addEventListener("click", function () {
        babyTable.style.display = "block";
        mothersTable.style.display = "none";
        showBabiesBtn.classList.add("active");
        showMothersBtn.classList.remove("active");
      });

      showMothersBtn.addEventListener("click", function () {
        babyTable.style.display = "none";
        mothersTable.style.display = "block";
        showBabiesBtn.classList.remove("active");
        showMothersBtn.classList.add("active");
      });

      // Simple search functionality
      document
        .getElementById("patientSearch")
        .addEventListener("keyup", function () {
          const searchTerm = this.value.toLowerCase();
          const activeTable = showBabiesBtn.classList.contains("active")
            ? babyTable
            : mothersTable;
          const rows = activeTable.querySelectorAll("tbody tr");

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
        .getElementById("statusFilter")
        .addEventListener("change", applyFilters);
      document
        .getElementById("ageFilter")
        .addEventListener("change", applyFilters);
      document
        .getElementById("areaFilter")
        .addEventListener("change", applyFilters);
      document
        .getElementById("midwifeFilter")
        .addEventListener("change", applyFilters);

      function applyFilters() {
        const statusFilter = document.getElementById("statusFilter").value;
        const ageFilter = document.getElementById("ageFilter").value;
        const areaFilter = document.getElementById("areaFilter").value;
        const midwifeFilter = document.getElementById("midwifeFilter").value;

        const activeTable = showBabiesBtn.classList.contains("active")
          ? babyTable
          : mothersTable;
        const rows = activeTable.querySelectorAll("tbody tr");

        rows.forEach((row) => {
          const status = row.querySelector(".badge").className.toLowerCase();
          const age = row.cells[2].textContent.toLowerCase();
          const area = row.cells[4].textContent.toLowerCase();
          const midwife = row.cells[5].textContent.toLowerCase();

          const statusMatch =
            !statusFilter ||
            (statusFilter === "active" && status.includes("active")) ||
            (statusFilter === "inactive" && status.includes("inactive")) ||
            (statusFilter === "high-risk" && status.includes("high-risk"));

          const ageMatch =
            !ageFilter ||
            (ageFilter === "0-1" && age.includes("month")) ||
            (ageFilter === "1-3" &&
              (age.includes("1 year") || age.includes("2 year"))) ||
            (ageFilter === "3-5" && age.includes("3 year")) ||
            (ageFilter === "5+" && parseInt(age) >= 5);

          const areaMatch =
            !areaFilter || area.includes(areaFilter.toLowerCase());
          const midwifeMatch =
            !midwifeFilter || midwife.includes(midwifeFilter.toLowerCase());

          if (statusMatch && ageMatch && areaMatch && midwifeMatch) {
            row.style.display = "";
          } else {
            row.style.display = "none";
          }
        });
      }
    </script>
  </body>
</html>
