<?php
/**
 * Blade template for the Report Generator interface, displaying dynamic data from the babies and reports tables.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report Generator | Baby Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .report-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border-top: 4px solid var(--teal);
        }

        .report-card h5 {
            color: var(--teal-dark);
            margin-bottom: 15px;
        }

        .stat-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            background: white;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--navy);
        }

        .stat-label {
            font-size: 16px;
            color: #6c757d;
        }

        .filter-section {
            background-color: var(--light-blue);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .preview-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            min-height: 400px;
        }

        .growth-chart-container {
            height: 250px;
            margin-top: 20px;
        }

        .highlight {
            background-color: var(--light-blue);
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
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

            .report-card {
                padding: 15px;
            }

            .stat-number {
                font-size: 24px;
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
        <h5 class="mb-0">Report Generator</h5>
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
                    <a href="{{ route('midwife.appointments') }}" class="nav-link "style="color:white">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </li>
                <li>
                    <a href="{{ route('thriposha.distribution') }}" class="nav-link active" style="color:white">
                        <i class="fas fa-utensils"></i> Nutrition
                    </a>
                </li>
               <li>
                    <a href="{{ route('vaccination_alerts.index') }}" class="nav-link"style="color:white">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports.index') }}" class="nav-link" style="color:white">
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
        <!-- Top Navigation Bar -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center arrow">
                        <a href="{{ url()->previous() }}" class="back-btn me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0 d-none d-md-block text-white">
                            Report Generator
                        </h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('reports.index') }}" method="GET">
                            <div class="input-group search-box me-3">
                                <input type="text" name="search" class="form-control bg-transparent border-0" placeholder="Search reports..." value="{{ request('search') }}" />
                                <button class="btn search-btn" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Stats Overview -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $activeBabies }}</div>
                        <div class="stat-label">Active Babies</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $reportsGenerated }}</div>
                        <div class="stat-label">Reports Generated</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $dueCheckups }}</div>
                        <div class="stat-label">Due Check-ups</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $vaccinationsDue }}</div>
                        <div class="stat-label">Vaccinations Due</div>
                    </div>
                </div>
            </div>

            <!-- Report Tabs -->
            <ul class="nav nav-pills mb-4">
                <li class="nav-item">
                    <button class="nav-link active" id="generate-tab">
                        <i class="fas fa-file-medical me-1"></i> Generate Report
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="history-tab">
                        <i class="fas fa-history me-1"></i> Report History
                    </button>
                </li>
            </ul>

            <!-- Generate Report View (Default) -->
            <div id="generateView">
                <div class="row">
                    <div class="col-lg-5">
                        <!-- Filter Section -->
                        <div class="report-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Report Filters</h5>
                                <button class="btn btn-sm btn-outline-secondary" onclick="resetFilters()">Clear All</button>
                            </div>
                            <div class="filter-section">
                                <form action="{{ route('reports.generate') }}" method="POST" id="reportForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Report Category</label>
                                        <select class="form-select" name="report_category" id="reportCategory" onchange="toggleReportFields()">
                                            <option value="">Select Category</option>
                                            <option value="client_report">Client Report</option>
                                            <option value="work_report">Work Report</option>
                                        </select>
                                    </div>

                                    <!-- Client Report Fields -->
                                    <div id="clientReportFields" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Select Client</label>
                                            <select class="form-select" name="baby_id">
                                                <option value="">All Babies</option>
                                                @foreach ($babies as $baby)
                                                    <option value="{{ $baby->id }}" {{ $selectedBaby && $selectedBaby->id == $baby->id ? 'selected' : '' }}>
                                                        {{ $baby->name }} ({{ $baby->age }} years)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Data to Include</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="data[]" value="weight_height" checked>
                                                <label class="form-check-label">Weight & Height</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="data[]" value="head_circumference" checked>
                                                <label class="form-check-label">Head Circumference</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="data[]" value="vaccination_records">
                                                <label class="form-check-label">Vaccination Records</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="data[]" value="feeding_data" checked>
                                                <label class="form-check-label">Feeding Data</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="data[]" value="sleep_patterns">
                                                <label class="form-check-label">Sleep Patterns</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Work Report Fields -->
                                    <div id="workReportFields" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">Report Type</label>
                                            <select class="form-select" name="report_type">
                                                <option value="appointment_report">Appointment Report</option>
                                                <option value="vaccination_report">Vaccination Report</option>
                                                <option value="health_checkup_report">Health Checkup Report</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Date From</label>
                                        <input type="date" class="form-control" name="date_from" value="{{ \Carbon\Carbon::today()->subMonths(6)->format('Y-m-d') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date To</label>
                                        <input type="date" class="form-control" name="date_to" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-medical me-2"></i> Generate Report</button>
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-print me-2"></i> Print Preview</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Recent Reports -->
                        <div class="report-card">
                            <h5>Recent Reports</h5>
                            <div class="list-group list-group-flush">
                                @foreach ($recentReports as $report)
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $report->file_path['baby_name'] ?? 'Unknown Baby' }} - {{ $report->report_type }}</h6>
                                            <small>{{ \Carbon\Carbon::parse($report->generated_at)->diffForHumans() }}</small>
                                        </div>
                                        <small class="text-muted">Generated: {{ \Carbon\Carbon::parse($report->generated_at)->format('M d, Y') }}</small>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <!-- Report Preview -->
                        @if ($selectedBaby)
                            <div class="report-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="mb-0">Report Preview: {{ $selectedBaby->name }}</h5>
                                    <div>
                                        <button class="btn btn-sm btn-outline-secondary me-1"><i class="fas fa-download"></i></button>
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-print"></i></button>
                                    </div>
                                </div>
                                <div class="preview-container">
                                    <div class="text-center mb-4">
                                        <h4>Baby Growth Report</h4>
                                        <p class="text-muted">For: {{ $selectedBaby->name }} | Born: {{ \Carbon\Carbon::parse($selectedBaby->birth_date)->format('M d, Y') }} | Report Period: {{ \Carbon\Carbon::today()->subMonths(6)->format('M d, Y') }} - {{ \Carbon\Carbon::today()->format('M d, Y') }}</p>
                                        <hr>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="highlight">
                                                <h6>Vital Statistics</h6>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="fw-bold">Current Weight</div>
                                                        <div>{{ $reportData['weight'] }} kg</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="fw-bold">Current Height</div>
                                                        <div>{{ $reportData['height'] }} cm</div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <div class="fw-bold">Head Circumference</div>
                                                        <div>{{ $reportData['head_circumference'] }} cm</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="fw-bold">Latest Appointment</div>
                                                        <div>{{ $reportData['latest_appointment'] }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="highlight">
                                                <h6>Recent Developments</h6>
                                                <ul class="ps-3 mb-0">
                                                    @if (!empty($reportData['milestones']))
                                                        @foreach ($reportData['milestones'] as $milestone)
                                                            <li>{{ $milestone }}</li>
                                                        @endforeach
                                                    @else
                                                        <li>No milestones recorded</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Feeding Summary</h6>
                                        <p class="mb-0">{{ $reportData['feeding_data'] }}</p>
                                    </div>

                                    <div class="mt-3">
                                        <h6>Midwife Notes</h6>
                                        <p class="mb-0">{{ $reportData['notes'] }}</p>
                                        <p class="mt-2 mb-0">Dr. {{ $selectedBaby->midwife_name ?? 'Emily Johnson' }}, RN<br>{{ \Carbon\Carbon::today()->format('M d, Y') }}</p>
                                    </div>

                                    <h6>Growth Chart</h6>
                                    <div class="growth-chart-container">
                                        <canvas id="growthChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="report-card">
                                <p>No baby selected for preview.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- History View -->
            <div id="historyView" class="d-none">
                <div class="report-card">
                    <h5>Report History</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date Generated</th>
                                    <th>Baby Name</th>
                                    <th>Report Type</th>
                                    <th>Period</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentReports as $report)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($report->generated_at)->format('M d, Y') }}</td>
                                        <td>{{ $report->file_path['baby_name'] ?? 'Unknown Baby' }}</td>
                                        <td>{{ $report->report_type }}</td>
                                        <td>{{ \Carbon\Carbon::parse($report->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($report->end_date)->format('M d, Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-download"></i></button>
                                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Report history navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
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
    </div>

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
        document.getElementById("generate-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("history-tab").classList.remove("active");
            document.getElementById("generateView").classList.remove("d-none");
            document.getElementById("historyView").classList.add("d-none");
        });

        document.getElementById("history-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("generate-tab").classList.remove("active");
            document.getElementById("historyView").classList.remove("d-none");
            document.getElementById("generateView").classList.add("d-none");
        });

        // Toggle report fields based on category
        function toggleReportFields() {
            const category = document.getElementById("reportCategory").value;
            const clientFields = document.getElementById("clientReportFields");
            const workFields = document.getElementById("workReportFields");

            clientFields.style.display = category === "client_report" ? "block" : "none";
            workFields.style.display = category === "work_report" ? "block" : "none";
        }

        // Reset filters
        function resetFilters() {
            document.getElementById("reportForm").reset();
            toggleReportFields();
        }

        // Initialize growth chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('growthChart').getContext('2d');
            const growthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($growthData['labels']),
                    datasets: [{
                        label: 'Weight (kg)',
                        data: @json($growthData['weight']),
                        borderColor: '#2b7c85',
                        backgroundColor: 'rgba(43, 124, 133, 0.1)',
                        tension: 0.3,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Height (cm)',
                        data: @json($growthData['height']),
                        borderColor: '#175873',
                        backgroundColor: 'rgba(23, 88, 115, 0.1)',
                        tension: 0.3,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Weight (kg)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Height (cm)'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
