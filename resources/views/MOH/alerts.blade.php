<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MOH Alerts | Baby Tracking System</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css"
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

      .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 15px;
      }

      .card-icon.bg-teal {
        background-color: rgba(19, 100, 109, 0.15);
        color: var(--primary-blue);
      }

      .card-icon.bg-orange {
        background-color: rgba(255, 159, 64, 0.15);
        color: #ff9f40;
      }

      .card-icon.bg-purple {
        background-color: rgba(153, 102, 255, 0.15);
        color: #9966ff;
      }

      .card-icon.bg-red {
        background-color: rgba(255, 99, 132, 0.15);
        color: #ff6384;
      }

      /* Charts Container */
      .chart-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 25px;
      }

      /* Recent Activities */
      .activity-item {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
      }

      .activity-item:last-child {
        border-bottom: none;
      }

      .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(19, 100, 109, 0.1);
        color: var(--primary-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 16px;
      }

      .activity-content {
        flex: 1;
      }

      /* Quick Actions */
      .quick-action {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 15px;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        text-align: center;
        height: 100%;
        color: #555;
        text-decoration: none;
      }

      .quick-action:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        color: var(--primary-blue);
      }

      .quick-action i {
        font-size: 24px;
        margin-bottom: 10px;
        color: var(--primary-blue);
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

      /* Profile Modal */
      .profile-modal .modal-header {
        background: linear-gradient(
          135deg,
          var(--dark-blue) 0%,
          var(--primary-blue) 100%
        );
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
      <h5 class="mb-0">Alerts</h5>
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
            <a href="Clinic.html" class="nav-link">
              <i class="fas fa-hospital-user"></i> Clinic Visits
            </a>
          </li>
          <li>
            <a href="Vaccinations.html" class="nav-link">
              <i class="fas fa-syringe"></i> Vaccinations
            </a>
          </li>
          <li>
            <a href="PHM.html" class="nav-link">
              <i class="fas fa-user-nurse"></i> PHM Management
            </a>
          </li>
          <li>
            <a href="Nutrition.html" class="nav-link">
              <i class="fas fa-utensils"></i> Nutrition
            </a>
          </li>
          <li>
            <a href="Alerts.html" class="nav-link active">
              <i class="fas fa-bell"></i> Alerts
            </a>
          </li>
          <li>
            <a href="Reports.html" class="nav-link">
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
          <h1 class="h2">Alerts Management</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createAlertModal">
                <i class="fas fa-bell"></i> Create New Alert
              </button>
              <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-cog"></i> Settings
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
          <div class="col-6 col-md-3 mb-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="card-icon bg-teal">
                  <i class="fas fa-bell"></i>
                </div>
                <h5 class="card-title">Active Alerts</h5>
                <h2 class="mb-0">18</h2>
                <p class="text-muted mb-0">
                  <span class="text-success"
                    ><i class="fas fa-arrow-up"></i> 3</span
                  >
                  today
                </p>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3 mb-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="card-icon bg-orange">
                  <i class="fas fa-exclamation-circle"></i>
                </div>
                <h5 class="card-title">High Priority</h5>
                <h2 class="mb-0">5</h2>
                <p class="text-muted mb-0">
                  <span class="text-danger"
                    ><i class="fas fa-arrow-up"></i> 1</span
                  >
                  today
                </p>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3 mb-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="card-icon bg-purple">
                  <i class="fas fa-syringe"></i>
                </div>
                <h5 class="card-title">Vaccination Alerts</h5>
                <h2 class="mb-0">8</h2>
                <p class="text-muted mb-0">
                  <span class="text-success"
                    ><i class="fas fa-arrow-up"></i> 2</span
                  >
                  today
                </p>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3 mb-3">
            <div class="card dashboard-card">
              <div class="card-body">
                <div class="card-icon bg-red">
                  <i class="fas fa-check-circle"></i>
                </div>
                <h5 class="card-title">Resolved Alerts</h5>
                <h2 class="mb-0">42</h2>
                <p class="text-muted mb-0">
                  <span class="text-success"
                    ><i class="fas fa-arrow-up"></i> 4</span
                  >
                  this week
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Alert Distribution and Alerts Over Time -->
        <div class="row mb-4">
          <div class="col-lg-6 mb-4">
            <div class="chart-container">
              <h5 class="mb-3">Alert Type Distribution</h5>
              <canvas id="alertTypeChart" height="300"></canvas>
            </div>
          </div>
          <div class="col-lg-6 mb-4">
            <div class="chart-container">
              <h5 class="mb-3">Alerts Over Time</h5>
              <canvas id="alertsOverTimeChart" height="300"></canvas>
            </div>
          </div>
        </div>

        <!-- Active Alerts Table -->
        <div class="row">
          <div class="col-lg-12 mb-4">
            <div class="chart-container">
              <div
                class="d-flex justify-content-between align-items-center mb-3"
              >
                <h5 class="mb-0">Active Alerts</h5>
                <div>
                  <input
                    type="text"
                    class="form-control form-control-sm d-inline-block"
                    placeholder="Search by ID or description"
                    style="width: 200px"
                  />
                  <button class="btn btn-sm btn-outline-primary ms-2">
                    Filter
                  </button>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Alert ID</th>
                      <th>Description</th>
                      <th>Type</th>
                      <th>Priority</th>
                      <th>Assigned To</th>
                      <th>Date Issued</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>AL-2025-001</td>
                      <td>Overdue Vaccination for Emma Johnson (B-1042)</td>
                      <td>Vaccination</td>
                      <td><span class="badge bg-warning">Medium</span></td>
                      <td>N. Perera</td>
                      <td>2025-05-18</td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">
                          Review
                        </button>
                        <button class="btn btn-sm btn-outline-success ms-1">
                          Resolve
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>AL-2025-002</td>
                      <td>High Risk Pregnancy - Mrs. Priya Patel (PW-2003)</td>
                      <td>High Risk</td>
                      <td><span class="badge bg-danger">High</span></td>
                      <td>R. Silva</td>
                      <td>2025-05-17</td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">
                          Review
                        </button>
                        <button class="btn btn-sm btn-outline-success ms-1">
                          Resolve
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>AL-2025-003</td>
                      <td>Low Vaccination Rate in Colombo 07</td>
                      <td>PHM Performance</td>
                      <td><span class="badge bg-warning">Medium</span></td>
                      <td>R. Silva</td>
                      <td>2025-05-16</td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">
                          Review
                        </button>
                        <button class="btn btn-sm btn-outline-success ms-1">
                          Resolve
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>AL-2025-004</td>
                      <td>Missed Clinic Visit - Aarav Patel (B-1003)</td>
                      <td>Clinic</td>
                      <td><span class="badge bg-warning">Medium</span></td>
                      <td>L. Bandara</td>
                      <td>2025-05-15</td>
                      <td>
                        <button class="btn btn-sm btn-outline-primary">
                          Review
                        </button>
                        <button class="btn btn-sm btn-outline-success ms-1">
                          Resolve
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <a href="#" class="btn btn-outline-primary w-100 mt-2"
                >View All Alerts</a
              >
            </div>
          </div>
        </div>

        <!-- Quick Actions and Recent Alert Activities -->
        <div class="row">
          <div class="col-lg-4 mb-4">
            <div class="chart-container">
              <h5 class="mb-3">Quick Actions</h5>
              <div class="row g-3">
                <div class="col-6">
                  <a href="#" class="quick-action" data-bs-toggle="modal" data-bs-target="#createAlertModal">
                    <i class="fas fa-bell"></i>
                    <span>Create Alert</span>
                  </a>
                </div>
                <div class="col-6">
                  <a href="#" class="quick-action">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Notification</span>
                  </a>
                </div>
                <div class="col-6">
                  <a href="#" class="quick-action">
                    <i class="fas fa-check-circle"></i>
                    <span>Resolve All</span>
                  </a>
                </div>
                <div class="col-6">
                  <a href="#" class="quick-action">
                    <i class="fas fa-chart-pie"></i>
                    <span>Alert Analytics</span>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-8 mb-4">
            <div class="chart-container">
              <div
                class="d-flex justify-content-between align-items-center mb-3"
              >
                <h5 class="mb-0">Recent Alert Activities</h5>
                <a href="#" class="btn btn-sm btn-outline-secondary"
                  >View All</a
                >
              </div>
              <div class="activity-list">
                <div class="activity-item">
                  <div class="activity-icon">
                    <i class="fas fa-bell"></i>
                  </div>
                  <div class="activity-content">
                    <strong>Alert issued</strong> - Overdue Vaccination for Emma Johnson (AL-2025-001)
                    <div>By Dr. Medical Officer</div>
                  </div>
                </div>
                <div class="activity-item">
                  <div class="activity-icon">
                    <i class="fas fa-exclamation-circle"></i>
                  </div>
                  <div class="activity-content">
                    <strong>High priority alert</strong> - High Risk Pregnancy for Mrs. Priya Patel (AL-2025-002)
                    <div>By Dr. Medical Officer</div>
                  </div>
                </div>
                <div class="activity-item">
                  <div class="activity-icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <div class="activity-content">
                    <strong>Alert resolved</strong> - Vaccination completed for Liam Garcia (B-1002)
                    <div>By S. Fernando</div>
                  </div>
                </div>
                <div class="activity-item">
                  <div class="activity-icon">
                    <i class="fas fa-paper-plane"></i>
                  </div>
                  <div class="activity-content">
                    <strong>Notification sent</strong> - Missed Clinic Visit for Aarav Patel (AL-2025-004)
                    <div>By L. Bandara</div>
                  </div>
                </div>
              </div>
            </div>
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

    <!-- Create Alert Modal -->
    <div
      class="modal fade"
      id="createAlertModal"
      tabindex="-1"
      aria-labelledby="createAlertModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="createAlertModalLabel">Create New Alert</h5>
            <button
              type="button"
              class="btn-close btn-close-white"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3">
                <label for="alertType" class="form-label">Alert Type</label>
                <select class="form-select" id="alertType">
                  <option value="vaccination">Vaccination</option>
                  <option value="high_risk">High Risk</option>
                  <option value="phm_performance">PHM Performance</option>
                  <option value="clinic">Clinic</option>
                  <option value="nutrition">Nutrition</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="alertPriority" class="form-label">Priority</label>
                <select class="form-select" id="alertPriority">
                  <option value="low">Low</option>
                  <option value="medium">Medium</option>
                  <option value="high">High</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="alertDescription" class="form-label">Description</label>
                <textarea class="form-control" id="alertDescription" rows="4" placeholder="Enter alert details"></textarea>
              </div>
              <div class="mb-3">
                <label for="alertAssignedTo" class="form-label">Assigned To</label>
                <select class="form-select" id="alertAssignedTo">
                  <option value="n_perera">N. Perera</option>
                  <option value="s_fernando">S. Fernando</option>
                  <option value="r_silva">R. Silva</option>
                  <option value="l_bandara">L. Bandara</option>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Create</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
      // Enhanced mobile menu functionality
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

      document.querySelectorAll(".sidebar .nav-link").forEach((link) => {
        link.addEventListener("click", function () {
          if (window.innerWidth <= 992) {
            sidebar.classList.remove("show");
            overlay.style.display = "none";
          }
        });
      });

      // Alert Type Distribution Chart
      const typeCtx = document
        .getElementById("alertTypeChart")
        .getContext("2d");
      const typeChart = new Chart(typeCtx, {
        type: "doughnut",
        data: {
          labels: ["Vaccination", "High Risk", "PHM Performance", "Clinic", "Nutrition"],
          datasets: [
            {
              data: [40, 25, 20, 10, 5],
              backgroundColor: [
                "rgba(19, 100, 109, 0.8)",
                "rgba(255, 99, 132, 0.8)",
                "rgba(153, 102, 255, 0.8)",
                "rgba(255, 159, 64, 0.8)",
                "rgba(54, 162, 235, 0.8)",
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "bottom",
            },
          },
        },
      });

      // Alerts Over Time Chart
      const timeCtx = document
        .getElementById("alertsOverTimeChart")
        .getContext("2d");
      const timeChart = new Chart(timeCtx, {
        type: "line",
        data: {
          labels: ["May 14", "May 15", "May 16", "May 17", "May 18"],
          datasets: [
            {
              label: "Alerts Issued",
              data: [10, 12, 15, 13, 18],
              borderColor: "rgba(19, 100, 109, 1)",
              backgroundColor: "rgba(19, 100, 109, 0.2)",
              fill: true,
              tension: 0.4,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: false,
            },
          },
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: "Number of Alerts",
              },
            },
          },
        },
      });
    </script>
  </body>
</html>
