<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nutrition Management | MOH Dashboard</title>
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
        --nutrition-green: #28a745;
        --nutrition-orange: #fd7e14;
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

      /* Nutrition Specific Cards */
      .nutrition-card {
        border-left: 4px solid var(--nutrition-green);
      }

      .warning-card {
        border-left: 4px solid var(--nutrition-orange);
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

      /* Nutrition Table Styles */
      .nutrition-table-container {
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

      .status-adequate {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
      }

      .status-moderate {
        background-color: rgba(255, 193, 7, 0.2);
        color: #ffc107;
      }

      .status-severe {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
      }

      .status-exclusive {
        background-color: rgba(13, 110, 253, 0.2);
        color: #0d6efd;
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

      /* Growth Chart Container */
      .growth-chart-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 25px;
        height: 400px;
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
      <h5 class="mb-0">Nutrition Management</h5>
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
            <a href="phm.html" class="nav-link">
              <i class="fas fa-user-nurse"></i>PHM Management
            </a>
          </li>
          <li>
            <a href="nutrition.html" class="nav-link active">
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
          <h1 class="h2">Nutrition Management</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button
                type="button"
                class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addNutritionModal"
              >
                <i class="fas fa-plus"></i> Add Nutrition Record
              </button>
              <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-file-export"></i> Export Data
              </button>
            </div>
          </div>
        </div>

        <!-- Nutrition Stats Cards -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="dashboard-card nutrition-card p-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-1">Adequate Nutrition</h6>
                  <h3 class="mb-0">856</h3>
                  <small class="text-success">72% of patients</small>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded">
                  <i class="fas fa-check-circle text-success"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="dashboard-card warning-card p-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-1">Moderate Malnutrition</h6>
                  <h3 class="mb-0">112</h3>
                  <small class="text-warning">9% of patients</small>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded">
                  <i class="fas fa-exclamation-triangle text-warning"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="dashboard-card p-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-1">Severe Malnutrition</h6>
                  <h3 class="mb-0">24</h3>
                  <small class="text-danger">2% of patients</small>
                </div>
                <div class="bg-danger bg-opacity-10 p-3 rounded">
                  <i class="fas fa-times-circle text-danger"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="dashboard-card p-3">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-1">Exclusive Breastfeeding</h6>
                  <h3 class="mb-0">684</h3>
                  <small class="text-primary">57% of infants</small>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                  <i class="fas fa-baby text-primary"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-container mb-4">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label for="nutritionStatusFilter" class="form-label">Nutrition Status</label>
              <select class="form-select" id="nutritionStatusFilter">
                <option value="">All Statuses</option>
                <option value="adequate">Adequate</option>
                <option value="moderate">Moderate Malnutrition</option>
                <option value="severe">Severe Malnutrition</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="ageGroupFilter" class="form-label">Age Group</label>
              <select class="form-select" id="ageGroupFilter">
                <option value="">All Ages</option>
                <option value="0-6">0-6 months</option>
                <option value="6-12">6-12 months</option>
                <option value="12-24">12-24 months</option>
                <option value="24+">2+ years</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="feedingTypeFilter" class="form-label">Feeding Type</label>
              <select class="form-select" id="feedingTypeFilter">
                <option value="">All Types</option>
                <option value="exclusive">Exclusive Breastfeeding</option>
                <option value="mixed">Mixed Feeding</option>
                <option value="formula">Formula Only</option>
                <option value="solid">Solid Foods</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label for="phmAreaFilter" class="form-label">PHM Area</label>
              <select class="form-select" id="phmAreaFilter">
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

        <!-- Growth Chart -->
        <div class="growth-chart-container mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Weight-for-Age Growth Chart</h5>
            <div>
              <select class="form-select form-select-sm" style="width: 150px">
                <option>Weight-for-Age</option>
                <option>Height-for-Age</option>
                <option>Weight-for-Height</option>
                <option>BMI-for-Age</option>
              </select>
            </div>
          </div>
          <div id="growthChart" style="height: 300px">
            <!-- Chart will be rendered here -->
            <div class="d-flex justify-content-center align-items-center h-100">
              <div class="text-center text-muted">
                <i class="fas fa-chart-line fa-3x mb-2"></i>
                <p>Growth chart visualization will appear here</p>
              </div>
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
                id="nutritionSearch"
                placeholder="Search patients by name, ID, or mother's name..."
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="alert alert-info p-2 mb-0 text-center">
              <strong>Total Patients:</strong> 1,248 |
              <strong>Last Month:</strong> 42 new assessments
            </div>
          </div>
        </div>

        <!-- Nutrition Table -->
        <div class="nutrition-table-container">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Patient ID</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Feeding Type</th>
                  <th>Last Weight</th>
                  <th>Status</th>
                  <th>Last Assessment</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>B-1042</td>
                  <td>
                    <strong>Emma Johnson</strong>
                    <div class="text-muted small">Female | Colombo 05</div>
                  </td>
                  <td>3 months</td>
                  <td>Exclusive Breastfeeding</td>
                  <td>6.2 kg</td>
                  <td>
                    <span class="badge badge-pill status-adequate">Adequate</span>
                  </td>
                  <td>15 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success action-btn">
                      <i class="fas fa-utensils"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>B-1002</td>
                  <td>
                    <strong>Liam Garcia</strong>
                    <div class="text-muted small">Male | Colombo 03</div>
                  </td>
                  <td>8 months</td>
                  <td>Mixed Feeding</td>
                  <td>7.8 kg</td>
                  <td>
                    <span class="badge badge-pill status-moderate">Moderate</span>
                  </td>
                  <td>12 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success action-btn">
                      <i class="fas fa-utensils"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>B-1003</td>
                  <td>
                    <strong>Aarav Patel</strong>
                    <div class="text-muted small">Male | Colombo 07</div>
                  </td>
                  <td>2 years</td>
                  <td>Solid Foods</td>
                  <td>10.5 kg</td>
                  <td>
                    <span class="badge badge-pill status-severe">Severe</span>
                  </td>
                  <td>10 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success action-btn">
                      <i class="fas fa-utensils"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td>B-1045</td>
                  <td>
                    <strong>Sophia Williams</strong>
                    <div class="text-muted small">Female | Colombo 02</div>
                  </td>
                  <td>4 months</td>
                  <td>Exclusive Breastfeeding</td>
                  <td>5.9 kg</td>
                  <td>
                    <span class="badge badge-pill status-adequate">Adequate</span>
                  </td>
                  <td>14 Jun 2023</td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary action-btn">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary action-btn">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success action-btn">
                      <i class="fas fa-utensils"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav aria-label="Nutrition pagination">
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

    <!-- Add Nutrition Record Modal -->
    <div
      class="modal fade"
      id="addNutritionModal"
      tabindex="-1"
      aria-labelledby="addNutritionModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="addNutritionModalLabel">
              Add Nutrition Assessment
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
                  <label for="patientSelect" class="form-label">Patient</label>
                  <select class="form-select" id="patientSelect" required>
                    <option value="">Select Patient</option>
                    <option value="B-1042">Emma Johnson (B-1042)</option>
                    <option value="B-1002">Liam Garcia (B-1002)</option>
                    <option value="B-1003">Aarav Patel (B-1003)</option>
                    <option value="B-1045">Sophia Williams (B-1045)</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="assessmentDate" class="form-label">Assessment Date</label>
                  <input type="date" class="form-control" id="assessmentDate" required />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="weight" class="form-label">Weight (kg)</label>
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    id="weight"
                    required
                  />
                </div>
                <div class="col-md-4">
                  <label for="height" class="form-label">Height (cm)</label>
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    id="height"
                    required
                  />
                </div>
                <div class="col-md-4">
                  <label for="muac" class="form-label">MUAC (cm)</label>
                  <input
                    type="number"
                    step="0.1"
                    class="form-control"
                    id="muac"
                    required
                  />
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="feedingType" class="form-label">Feeding Type</label>
                  <select class="form-select" id="feedingType" required>
                    <option value="">Select Feeding Type</option>
                    <option value="exclusive">Exclusive Breastfeeding</option>
                    <option value="mixed">Mixed Feeding</option>
                    <option value="formula">Formula Only</option>
                    <option value="solid">Solid Foods</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="nutritionStatus" class="form-label">Nutrition Status</label>
                  <select class="form-select" id="nutritionStatus" required>
                    <option value="">Select Status</option>
                    <option value="adequate">Adequate</option>
                    <option value="moderate">Moderate Malnutrition</option>
                    <option value="severe">Severe Malnutrition</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="dietDetails" class="form-label">Diet Details</label>
                <textarea
                  class="form-control"
                  id="dietDetails"
                  rows="2"
                  placeholder="Describe current diet..."
                ></textarea>
              </div>

              <div class="mb-3">
                <label for="recommendations" class="form-label">Recommendations</label>
                <textarea
                  class="form-control"
                  id="recommendations"
                  rows="3"
                  placeholder="Enter nutritional recommendations..."
                  required
                ></textarea>
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="followupRequired" />
                <label class="form-check-label" for="followupRequired">
                  Follow-up required
                </label>
              </div>

              <div class="row mb-3" id="followupSection" style="display: none">
                <div class="col-md-6">
                  <label for="followupDate" class="form-label">Follow-up Date</label>
                  <input type="date" class="form-control" id="followupDate" />
                </div>
                <div class="col-md-6">
                  <label for="followupReason" class="form-label">Reason</label>
                  <input
                    type="text"
                    class="form-control"
                    id="followupReason"
                    placeholder="Reason for follow-up"
                  />
                </div>
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
              Save Assessment
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Profile Modal -->
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

      // Follow-up section toggle
      document
        .getElementById("followupRequired")
        .addEventListener("change", function () {
          document.getElementById("followupSection").style.display = this.checked
            ? "block"
            : "none";
        });

      // Simple search functionality
      document
        .getElementById("nutritionSearch")
        .addEventListener("keyup", function () {
          const searchTerm = this.value.toLowerCase();
          const rows = document.querySelectorAll(".nutrition-table-container tbody tr");

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
        .getElementById("nutritionStatusFilter")
        .addEventListener("change", applyNutritionFilters);
      document
        .getElementById("ageGroupFilter")
        .addEventListener("change", applyNutritionFilters);
      document
        .getElementById("feedingTypeFilter")
        .addEventListener("change", applyNutritionFilters);
      document
        .getElementById("phmAreaFilter")
        .addEventListener("change", applyNutritionFilters);

      function applyNutritionFilters() {
        const statusFilter = document.getElementById("nutritionStatusFilter").value;
        const ageFilter = document.getElementById("ageGroupFilter").value;
        const feedingFilter = document.getElementById("feedingTypeFilter").value;
        const phmFilter = document.getElementById("phmAreaFilter").value;

        const rows = document.querySelectorAll(".nutrition-table-container tbody tr");

        rows.forEach((row) => {
          const status = row.querySelector(".badge").className.toLowerCase();
          const age = row.cells[2].textContent.toLowerCase();
          const feeding = row.cells[3].textContent.toLowerCase();
          const phm = row.cells[1].querySelector(".text-muted").textContent.toLowerCase();

          const statusMatch =
            !statusFilter ||
            (statusFilter === "adequate" && status.includes("adequate")) ||
            (statusFilter === "moderate" && status.includes("moderate")) ||
            (statusFilter === "severe" && status.includes("severe"));

          const ageMatch =
            !ageFilter ||
            (ageFilter === "0-6" && parseInt(age) <= 6) ||
            (ageFilter === "6-12" && parseInt(age) > 6 && parseInt(age) <= 12) ||
            (ageFilter === "12-24" && parseInt(age) > 12 && parseInt(age) <= 24) ||
            (ageFilter === "24+" && parseInt(age) > 24);

          const feedingMatch =
            !feedingFilter ||
            (feedingFilter === "exclusive" && feeding.includes("exclusive")) ||
            (feedingFilter === "mixed" && feeding.includes("mixed")) ||
            (feedingFilter === "formula" && feeding.includes("formula")) ||
            (feedingFilter === "solid" && feeding.includes("solid"));

          const phmMatch = !phmFilter || phm.includes(phmFilter.toLowerCase());

          if (statusMatch && ageMatch && feedingMatch && phmMatch) {
            row.style.display = "";
          } else {
            row.style.display = "none";
          }
        });
      }
    </script>
  </body>
</html>
