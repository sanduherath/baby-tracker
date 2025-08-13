<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Management | Baby Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* Your existing CSS remains unchanged */
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

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
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

        /* Main Content */
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Mobile Header */
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

        /* Top Navigation Bar */
        .top-bar {
            background: var(--primary-blue);
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

        .profile-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            color: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid white;
        }

        .profile-circle:hover {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        /* Search box */
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

        /* Table Styles */
        .table-container {
            max-height: calc(100vh - 250px);
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.125);
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

        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            margin: 4px;
        }

        .btn-primary {
            background-color: var(--teal);
            border-color: var(--teal);
            border-radius: 20px;
            padding: 8px 16px;
            text-decoration: none;
        }

        .arrow a {
            text-decoration: none;
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

            .top-bar {
                padding: 12px 0;
            }

            .back-btn {
                padding: 6px 12px;
                font-size: 13px;
            }

            .profile-circle {
                width: 36px;
                height: 36px;
                font-size: 14px;
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
                <img src="" class="rounded-circle mb-2 midphoto" alt="Profile" id="profileImage"
                    data-bs-toggle="modal" data-bs-target="#profileModal" />
                <h5>{{ Auth::user()->name }}</h5>
                <small class="text-white-50">Registered Midwife</small>
            </div>
           <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('midwife.dashboard') }}" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.patients') }}" class="nav-link active" style="color: #f8f9fa;">
                        <i class="fas fa-baby"></i> My Patients
                    </a>
                </li>
                <li>
                    <a href="{{ route('midwife.appointments') }}" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </li>

                <li>
                    <a href="{{ route('thriposha.distribution') }}" class="nav-link " style="color: #f8f9fa;">
                        <i class="fas fa-utensils"></i> Nutrition
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link" style="color: #f8f9fa;">
                        <i class="fas fa-bell"></i> Alerts
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link" style="color: #f8f9fa;">
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
                        {{-- <a href="{{ route('midwife.dashboard') }}" class="back-btn me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a> --}}
                        <h5 class="mb-0 d-none d-md-block text-white">&nbsp;&nbsp;&nbsp;&nbsp;Patient Management</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group search-box me-3">
                            <input type="text" class="form-control bg-transparent border-0"
                                placeholder="Search patients..." />
                            <button class="btn search-btn" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Patient Content -->
        <div class="container-fluid py-4">
            <!-- Display Success or Error Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Patient Type Tabs and Actions -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <ul class="nav nav-pills mb-3 mb-md-0">
                    <li class="nav-item">
                        <button class="nav-link active" id="babies-tab">
                            <i class="fas fa-baby me-1"></i> Babies
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="pregnant-tab">
                            <i class="fas fa-female me-1"></i> Pregnant Women
                        </button>
                    </li>
                </ul>
                <a href="{{ route('midwife.addpatient') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> New Patient
                </a>
            </div>

            <!-- Babies Table -->
            <div class="table-container mb-4" id="babiesTable">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 25%">Baby Name</th>
                            <th style="width: 25%">Mother's Name</th>
                            <th style="width: 15%">Patient ID</th>
                            <th style="width: 15%">Age</th>
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($babies as $baby)
                            <tr>
                                <td>{{ $baby->name }}</td>
                                <td>{{ $baby->mother_name }}</td>
                                <td>{{ $baby->registration_number ?? 'B-' . $baby->id }}</td>
                                <td>
                                    {{ round(\Carbon\Carbon::parse($baby->birth_date)->floatDiffInMonths(now()), 1) }}
                                    months old

                                </td>
                                <td>
                                    <a href="{{ route('baby.profile', $baby->id) }}"
                                        class="btn btn-outline-primary btn-sm action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('baby.delete', $baby->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No babies found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pregnant Women Table -->
            <div class="table-container mb-4 d-none" id="pregnantTable">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 20%">Full Name</th>
                            <th style="width: 15%">Patient ID</th>
                            <th style="width: 15%">NIC</th>
                            <th style="width: 10%">Age</th>
                            <th style="width: 15%">Gestation</th>
                            <th style="width: 25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pregnantWomen as $woman)
                            <tr>
                                <td>{{ $woman->name }}</td>
                                <td>{{ 'PW-' . $woman->id }}</td>
                                <td>{{ $woman->nic }}</td>
                                <td>
                                    @php
                                        $dob = \Carbon\Carbon::parse($woman->dob);
                                        $dob->toDateString(); // Check parsed DOB
                                        \Carbon\Carbon::now()->toDateString(); // Check current date
                                        $age = (int) $dob->diffInYears(\Carbon\Carbon::now());

                                    @endphp
                                    {{ $age }} years
                                </td>
                                <td>
                                    @php
                                        $lmpDate = \Carbon\Carbon::parse($woman->lmp_date);
                                        $gestation = round($lmpDate->diffInWeeks(\Carbon\Carbon::now()), 1);
                                    @endphp
                                    {{ $gestation }} weeks
                                </td>
                                <td>
                                    <a href="{{ route('pregnant.profile', $woman->id) }}"
                                        class="btn btn-outline-primary btn-sm action-btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('pregnant.delete', $woman->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No pregnant women found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality for both tables
        const searchInput = document.querySelector('.search-box input');
        const babiesTable = document.getElementById('babiesTable');
        const pregnantTable = document.getElementById('pregnantTable');
        const babiesRows = babiesTable.querySelectorAll('tbody tr');
        const pregnantRows = pregnantTable.querySelectorAll('tbody tr');

        function filterTable(searchTerm, rows, table) {
            let hasVisibleRows = false;
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;

                // Check relevant cells for Babies or Pregnant Women
                if (table === babiesTable) {
                    // Search in Baby Name (cells[0]), Mother's Name (cells[1]), Patient ID (cells[2])
                    match = cells[0].textContent.toLowerCase().includes(searchTerm) ||
                        cells[1].textContent.toLowerCase().includes(searchTerm) ||
                        cells[2].textContent.toLowerCase().includes(searchTerm);
                } else if (table === pregnantTable) {
                    // Search in Full Name (cells[0]), Patient ID (cells[1]), NIC (cells[2])
                    match = cells[0].textContent.toLowerCase().includes(searchTerm) ||
                        cells[1].textContent.toLowerCase().includes(searchTerm) ||
                        cells[2].textContent.toLowerCase().includes(searchTerm);
                }

                row.style.display = match ? '' : 'none';
                if (match) hasVisibleRows = true;
            });

            // Show "No results" message if no rows are visible
            const noResultsRow = table.querySelector('tbody tr td.text-center');
            if (noResultsRow) {
                noResultsRow.parentElement.style.display = hasVisibleRows ? 'none' : '';
            }
        }

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim().toLowerCase();

            // Filter the currently visible table
            if (!babiesTable.classList.contains('d-none')) {
                filterTable(searchTerm, babiesRows, babiesTable);
            } else if (!pregnantTable.classList.contains('d-none')) {
                filterTable(searchTerm, pregnantRows, pregnantTable);
            }
        });

        // Reset search when switching tabs
        document.getElementById('babies-tab').addEventListener('click', function() {
            searchInput.value = '';
            filterTable('', babiesRows, babiesTable);
        });

        document.getElementById('pregnant-tab').addEventListener('click', function() {
            searchInput.value = '';
            filterTable('', pregnantRows, pregnantTable);
        });
    </script>
    <script>
        // Enhanced mobile menu functionality
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

        // Toggle between tables
        document.getElementById("babies-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("pregnant-tab").classList.remove("active");
            document.getElementById("babiesTable").classList.remove("d-none");
            document.getElementById("pregnantTable").classList.add("d-none");
        });

        document.getElementById("pregnant-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("babies-tab").classList.remove("active");
            document.getElementById("pregnantTable").classList.remove("d-none");
            document.getElementById("babiesTable").classList.add("d-none");
        });

        // Initialize tooltips for action buttons
        var tooltipTriggerList = [].slice.call(document.querySelectorAll("[title]"));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>

</html>
