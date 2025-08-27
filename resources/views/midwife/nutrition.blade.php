<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Thriposha Distribution | Baby Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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

        /* Sidebar Styles */
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

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }

        /* Top Navigation Bar */
        .top-bar {
            background: linear-gradient(135deg,
                    var(--gradient-start),
                    var(--gradient-end));
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

        /* Content Area */
        .content-area {
            padding: 25px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Thriposha Tabs */
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

        /* Stock Cards */
        .stock-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border-top: 4px solid var(--teal);
        }

        .stock-card h5 {
            color: var(--teal-dark);
            margin-bottom: 15px;
        }

        .stock-amount {
            font-size: 28px;
            font-weight: 700;
            color: var(--navy);
        }

        .stock-unit {
            font-size: 16px;
            color: #6c757d;
        }

        .stock-status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
        }

        .status-good {
            background-color: #d4edda;
            color: #155724;
        }

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-critical {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Distribution Table */
        .distribution-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .distribution-table th {
            background-color: var(--teal);
            color: white;
            padding: 12px 15px;
            text-align: left;
        }

        .distribution-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .distribution-table tr:hover td {
            background-color: #f8f9fa;
        }

        /* Progress Bars */
        .progress-thin {
            height: 8px;
        }

        .arrow a {
            text-decoration: none;
        }

        /* Modal for Report Preview */
        .modal-report-preview .modal-dialog {
            max-width: 90%;
            width: 1000px;
        }

        .modal-report-preview .modal-body {
            padding: 0;
            height: 70vh;
            overflow-y: auto;
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

            .stock-card {
                padding: 15px;
            }

            .stock-amount {
                font-size: 24px;
            }

            .distribution-table th,
            .distribution-table td {
                padding: 8px 10px;
                font-size: 14px;
            }

            .modal-report-preview .modal-dialog {
                max-width: 95%;
            }

            .modal-report-preview .modal-body {
                height: 60vh;
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
        <h5 class="mb-0">Thriposha Distribution</h5>
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
                    <a href="{{ route('thriposha.distribution') }}" class="nav-link active"style="color:white">
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
                        <a href="{{ route('midwife.dashboard') }}" class="back-btn me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h5 class="mb-0 d-none d-md-block text-white">
                            Thriposha Distribution
                        </h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group search-box me-3">
                            <input type="text" class="form-control bg-transparent border-0"
                                placeholder="Search distributions..." />
                            <button class="btn search-btn" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Thriposha Tabs -->
            <ul class="nav nav-pills mb-4">
                <li class="nav-item">
                    <button class="nav-link active" id="stock-tab">
                        <i class="fas fa-boxes me-1"></i> Stock
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="orders-tab">
                        <i class="fas fa-truck me-1"></i> Orders
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="reports-tab">
                        <i class="fas fa-chart-bar me-1"></i> Reports
                    </button>
                </li>
            </ul>

            <!-- Stock View (Default) -->
            <div id="stockView">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="stock-card">
                            <h5>Baby Thriposha Stock</h5>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <span class="stock-amount" id="babyStockAmount">{{ $babyStock }}</span>
                                    <span class="stock-unit">packs (400g)</span>
                                </div>
                                <span class="stock-status" id="babyStockStatus">
                                    @if ($babyStock >= 100)
                                        <span class="status-good">Adequate</span>
                                    @elseif($babyStock >= 50)
                                        <span class="status-warning">Low</span>
                                    @else
                                        <span class="status-critical">Critical</span>
                                    @endif
                                </span>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted last-received-baby">Last received:
                                    {{ \App\Models\ThriposhaDistribution::where('type', 'baby')->where('transaction_type', 'addition')->latest()->first()?->date->format('M d, Y') ?? 'N/A' }}
                                    ({{ \App\Models\ThriposhaDistribution::where('type', 'baby')->where('transaction_type', 'addition')->latest()->first()?->quantity ?? 0 }}
                                    packs)</small>
                                <div class="progress progress-thin mt-1">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ min(($babyStock / 200) * 100, 100) }}%"
                                        aria-valuenow="{{ $babyStock }}" aria-valuemin="0" aria-valuemax="200">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stock-card">
                            <h5>Mother Thriposha Stock</h5>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <span class="stock-amount" id="motherStockAmount">{{ $motherStock }}</span>
                                    <span class="stock-unit">packs (400g)</span>
                                </div>
                                <span class="stock-status" id="motherStockStatus">
                                    @if ($motherStock >= 100)
                                        <span class="status-good">Adequate</span>
                                    @elseif($motherStock >= 50)
                                        <span class="status-warning">Low</span>
                                    @else
                                        <span class="status-critical">Critical</span>
                                    @endif
                                </span>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted last-received-mother">Last received:
                                    {{ \App\Models\ThriposhaDistribution::where('type', 'mother')->where('transaction_type', 'addition')->latest()->first()?->date->format('M d, Y') ?? 'N/A' }}
                                    ({{ \App\Models\ThriposhaDistribution::where('type', 'mother')->where('transaction_type', 'addition')->latest()->first()?->quantity ?? 0 }}
                                    packs)</small>
                                <div class="progress progress-thin mt-1">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: {{ min(($motherStock / 200) * 100, 100) }}%"
                                        aria-valuenow="{{ $motherStock }}" aria-valuemin="0" aria-valuemax="200">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="stock-card">
                            <h5>Recent Distributions</h5>
                            <div class="table-responsive">
                                <table class="distribution-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Recipient</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($distributions as $distribution)
                                            <tr>
                                                <td>{{ $distribution->date->format('M d, Y') }}</td>
                                                <td>{{ ucfirst($distribution->type) }}</td>
                                                <td>{{ $distribution->quantity }} packs</td>
                                                <td>{{ $distribution->recipient }}</td>
                                            </tr>
                                        @endforeach
                                        @if ($distributions->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">No distributions recorded.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#addStockModal">
                                <i class="fas fa-plus me-1"></i> Add Stock
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders View -->
            <div id="ordersView" class="d-none">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="stock-card">
                            <h5>Place New Order</h5>
                            <form id="orderForm">
                                <div class="mb-3">
                                    <label class="form-label">Thriposha Type</label>
                                    <select class="form-select" id="thriposhaType" name="thriposhaType" required>
                                        <option value="">Select type</option>
                                        <option value="baby">Baby Thriposha</option>
                                        <option value="mother">Mother Thriposha</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="orderQuantity"
                                        name="orderQuantity" min="10" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Urgency</label>
                                    <select class="form-select" id="orderUrgency" name="orderUrgency" required>
                                        <option value="normal">Normal (2-3 weeks)</option>
                                        <option value="urgent">Urgent (1 week)</option>
                                        <option value="emergency">Emergency (3 days)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" id="orderNotes" name="orderNotes" rows="2"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> Submit Order
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stock-card">
                            <h5>Order History</h5>
                            <div class="table-responsive">
                                <table class="distribution-table">
                                    <thead>
                                        <tr>
                                            <th>Order Date</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Expected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_date->format('M d, Y') }}</td>
                                                <td>{{ ucfirst($order->type) }}</td>
                                                <td>{{ $order->quantity }} packs</td>
                                                <td>
                                                    <span
                                                        class="stock-status
                                            {{ $order->status == 'delivered' ? 'status-good' : ($order->status == 'processing' ? 'status-warning' : 'status-critical') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $order->expected_delivery_date ? $order->expected_delivery_date->format('M d, Y') : 'N/A' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No orders recorded.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports View -->
            <div id="reportsView" class="d-none">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="stock-card">
                            <h5>Generate Report</h5>
                            <form id="reportForm">
                                <div class="mb-3">
                                    <label class="form-label">Report Type</label>
                                    <select class="form-select" id="reportType" name="reportType" required>
                                        <option value="">Select report type</option>
                                        <option value="distribution">Distribution Report</option>
                                        <option value="order">Order Report</option>
                                        <option value="stock">Total Stock Report</option>
                                    </select>
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="reportStartDate" name="startDate" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="reportEndDate" name="endDate" required />
                                    </div>
                                </div>
                                <div class="mb-3" id="recipientSelectContainer" style="display: none">
                                    <label class="form-label">Select Recipient</label>
                                    <select class="form-select" id="reportRecipientSelect" name="recipientId">
                                        <option value="">Select recipient</option>
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }}
                                                ({{ $patient->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary" id="downloadReportBtn">
                                        <i class="fas fa-download me-1"></i> Download Report
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" id="viewReportBtn">
                                        <i class="fas fa-eye me-1"></i> View Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stock-card">
                            <h5>Recent Reports</h5>
                            <div class="table-responsive">
                                <table class="distribution-table" id="recentReportsTable">
                                    <thead>
                                        <tr>
                                            <th>Generated</th>
                                            <th>Report Type</th>
                                            <th>Period</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Jun 10, 2023</td>
                                            <td>Distribution Report</td>
                                            <td>May 1-31, 2023</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1 download-report-btn">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary view-report-btn">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>May 31, 2023</td>
                                            <td>Total Stock Report</td>
                                            <td>Jan 1 - May 31, 2023</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1 download-report-btn">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary view-report-btn">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>May 15, 2023</td>
                                            <td>Order Report</td>
                                            <td>Jan 1 - May 15, 2023</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1 download-report-btn">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary view-report-btn">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Apr 30, 2023</td>
                                            <td>Distribution Report</td>
                                            <td>Apr 1-30, 2023</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1 download-report-btn">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary view-report-btn">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Add Thriposha Stock
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStockForm">
                        <div class="mb-3">
                            <label class="form-label">Thriposha Type</label>
                            <select class="form-select" id="stockThriposhaType" name="stockThriposhaType" required>
                                <option value="" disabled selected>Select type</option>
                                <option value="baby">Baby Thriposha</option>
                                <option value="mother">Mother Thriposha</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity (packs)</label>
                            <input type="number" class="form-control" id="stockQuantity" name="stockQuantity"
                                min="1" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" id="stockNotes" name="stockNotes" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addStockForm" class="btn btn-teal">
                        <i class="fas fa-plus me-1"></i> Add Stock
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Preview Modal -->
    <div class="modal fade modal-report-preview" id="reportPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-file-alt me-2"></i>Report Preview
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="reportPreviewContent">
                        <p>Loading report preview...</p>
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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

        // Toggle between views
        document.getElementById("stock-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("orders-tab").classList.remove("active");
            document.getElementById("reports-tab").classList.remove("active");
            document.getElementById("stockView").classList.remove("d-none");
            document.getElementById("ordersView").classList.add("d-none");
            document.getElementById("reportsView").classList.add("d-none");
        });

        document.getElementById("orders-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("stock-tab").classList.remove("active");
            document.getElementById("reports-tab").classList.remove("active");
            document.getElementById("ordersView").classList.remove("d-none");
            document.getElementById("stockView").classList.add("d-none");
            document.getElementById("reportsView").classList.add("d-none");
        });

        document.getElementById("reports-tab").addEventListener("click", function() {
            this.classList.add("active");
            document.getElementById("stock-tab").classList.remove("active");
            document.getElementById("orders-tab").classList.remove("active");
            document.getElementById("reportsView").classList.remove("d-none");
            document.getElementById("stockView").classList.add("d-none");
            document.getElementById("ordersView").classList.add("d-none");
        });

        // Show recipient select only when recipient report is selected
        document.getElementById("reportType").addEventListener("change", function() {
            const recipientContainer = document.getElementById("recipientSelectContainer");
            recipientContainer.style.display = "none";
            document.getElementById("reportRecipientSelect").removeAttribute("required");
        });

        // Add Stock Form Submission
        document.getElementById("addStockForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('thriposha.addStock') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    alert('Error: ' + Object.values(data.errors).join('\n'));
                    return;
                }

                // Update stock counts
                const babyStockAmount = document.getElementById('babyStockAmount');
                const motherStockAmount = document.getElementById('motherStockAmount');
                const babyStockStatus = document.getElementById('babyStockStatus');
                const motherStockStatus = document.getElementById('motherStockStatus');
                const babyProgressBar = document.querySelector(
                    '#stockView .col-md-6:nth-child(1) .progress-bar');
                const motherProgressBar = document.querySelector(
                    '#stockView .col-md-6:nth-child(2) .progress-bar');

                // Update Baby Thriposha
                babyStockAmount.textContent = data.babyStock;
                let babyStatusClass = data.babyStock >= 100 ? 'status-good' : data.babyStock >= 50 ?
                    'status-warning' : 'status-critical';
                let babyStatusText = data.babyStock >= 100 ? 'Adequate' : data.babyStock >= 50 ? 'Low' :
                    'Critical';
                babyStockStatus.innerHTML = `<span class="${babyStatusClass}">${babyStatusText}</span>`;
                babyProgressBar.style.width = `${Math.min((data.babyStock / 200) * 100, 100)}%`;
                babyProgressBar.setAttribute('aria-valuenow', data.babyStock);

                // Update Mother Thriposha
                motherStockAmount.textContent = data.motherStock;
                let motherStatusClass = data.motherStock >= 100 ? 'status-good' : data.motherStock >= 50 ?
                    'status-warning' : 'status-critical';
                let motherStatusText = data.motherStock >= 100 ? 'Adequate' : data.motherStock >= 50 ?
                    'Low' : 'Critical';
                motherStockStatus.innerHTML =
                    `<span class="${motherStatusClass}">${motherStatusText}</span>`;
                motherProgressBar.style.width = `${Math.min((data.motherStock / 200) * 100, 100)}%`;
                motherProgressBar.setAttribute('aria-valuenow', data.motherStock);

                // Update "Last received" information
                if (data.lastReceived) {
                    const lastReceivedElement = document.querySelector(
                        `.last-received-${data.lastReceived.type}`);
                    if (lastReceivedElement) {
                        lastReceivedElement.textContent =
                            `Last received: ${data.lastReceived.date} (${data.lastReceived.quantity} packs)`;
                    }
                }

                alert(data.success);
                bootstrap.Modal.getInstance(document.getElementById("addStockModal")).hide();
                this.reset();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding stock. Please try again.');
            });
        });

        // Order Form Submission
        document.getElementById("orderForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('thriposha.storeOrder') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.errors) {
                    alert('Error: ' + Object.values(data.errors).join('\n'));
                    return;
                }

                const tbody = document.querySelector('#ordersView .distribution-table tbody');
                const noOrdersRow = tbody.querySelector('tr td[colspan="5"]');
                if (noOrdersRow) {
                    noOrdersRow.parentElement.remove();
                }

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${data.order.order_date}</td>
                    <td>${data.order.type}</td>
                    <td>${data.order.quantity} packs</td>
                    <td><span class="stock-status ${data.order.status == 'delivered' ? 'status-good' : (data.order.status == 'processing' ? 'status-warning' : 'status-critical')}">${data.order.status}</span></td>
                    <td>${data.order.expected_delivery_date}</td>
                `;
                tbody.prepend(newRow);

                alert(data.success);
                this.reset();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while placing the order. Please try again.');
            });
        });

        // Download Report Form Submission
        document.getElementById("reportForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const reportType = formData.get('reportType');
            const startDate = formData.get('startDate');
            const endDate = formData.get('endDate');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Show the modal
            const reportModal = new bootstrap.Modal(document.getElementById('reportPreviewModal'));
            reportModal.show();

            fetch("{{ route('thriposha.generateReport') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                // Create a temporary element to hold the report content
                const tempElement = document.createElement('div');
                tempElement.innerHTML = html;

                // Use html2pdf to generate and download the PDF
                const opt = {
                    margin: 10,
                    filename: `${reportType}_report_${new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}.pdf`,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };

                html2pdf().from(tempElement).set(opt).save().then(() => {
                    // Update the Recent Reports table
                    const tbody = document.querySelector('#recentReportsTable tbody');
                    const reportTypeText = {
                        'distribution': 'Distribution Report',
                        'order': 'Order Report',
                        'stock': 'Total Stock Report'
                    }[reportType] || reportType;

                    const periodText = `${new Date(startDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} - ${new Date(endDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                    const generatedDate = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${generatedDate}</td>
                        <td>${reportTypeText}</td>
                        <td>${periodText}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1 download-report-btn" data-url="${opt.filename}">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary view-report-btn" data-html="${encodeURIComponent(html)}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    `;
                    tbody.prepend(newRow);

                    // Limit to 4 recent reports
                    while (tbody.children.length > 4) {
                        tbody.removeChild(tbody.lastChild);
                    }

                    // Add event listeners to the new buttons
                    newRow.querySelector('.download-report-btn').addEventListener('click', function() {
                        const link = document.createElement('a');
                        link.href = this.dataset.url;
                        link.download = this.dataset.url;
                        link.click();
                    });

                    newRow.querySelector('.view-report-btn').addEventListener('click', function() {
                        const reportModal = new bootstrap.Modal(document.getElementById('reportPreviewModal'));
                        document.getElementById('reportPreviewContent').innerHTML = decodeURIComponent(this.dataset.html);
                        reportModal.show();
                    });

                    // Close the modal
                    reportModal.hide();
                }).catch(error => {
                    console.error('Error generating PDF:', error);
                    alert('An error occurred while generating the PDF. Please try again.');
                    reportModal.hide();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while generating the report. Please try again.');
                reportModal.hide();
            });
        });

        // View Report Button
        document.getElementById("viewReportBtn").addEventListener("click", function() {
            const formData = new FormData(document.getElementById("reportForm"));
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const reportModal = new bootstrap.Modal(document.getElementById('reportPreviewModal'));
            reportModal.show();

            fetch("{{ route('thriposha.generateReport') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'text/html'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                document.getElementById('reportPreviewContent').innerHTML = html;

                // Update Recent Reports table
                const reportType = formData.get('reportType');
                const startDate = formData.get('startDate');
                const endDate = formData.get('endDate');
                const tbody = document.querySelector('#recentReportsTable tbody');
                const reportTypeText = {
                    'distribution': 'Distribution Report',
                    'order': 'Order Report',
                    'stock': 'Total Stock Report'
                }[reportType] || reportType;

                const periodText = `${new Date(startDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} - ${new Date(endDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                const generatedDate = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${generatedDate}</td>
                    <td>${reportTypeText}</td>
                    <td>${periodText}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1 download-report-btn" data-url="${reportType}_report_${generatedDate}.pdf">
                            <i class="fas fa-download"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary view-report-btn" data-html="${encodeURIComponent(html)}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                `;
                tbody.prepend(newRow);

                // Limit to 4 recent reports
                while (tbody.children.length > 4) {
                    tbody.removeChild(tbody.lastChild);
                }

                // Add event listeners to the new buttons
                newRow.querySelector('.download-report-btn').addEventListener('click', function() {
                    const formData = new FormData(document.getElementById("reportForm"));
                    fetch("{{ route('thriposha.generateReport') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const tempElement = document.createElement('div');
                        tempElement.innerHTML = html;
                        const opt = {
                            margin: 10,
                            filename: this.dataset.url,
                            image: { type: 'jpeg', quality: 0.98 },
                            html2canvas: { scale: 2 },
                            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                        };
                        html2pdf().from(tempElement).set(opt).save();
                    });
                });

                newRow.querySelector('.view-report-btn').addEventListener('click', function() {
                    document.getElementById('reportPreviewContent').innerHTML = decodeURIComponent(this.dataset.html);
                    reportModal.show();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('reportPreviewContent').innerHTML = '<p>Error loading report. Please try again.</p>';
            });
        });

        // Handle existing download and view buttons
        document.querySelectorAll('.download-report-btn').forEach(button => {
            button.addEventListener('click', function() {
                const link = document.createElement('a');
                link.href = this.dataset.url;
                link.download = this.dataset.url;
                link.click();
            });
        });

        document.querySelectorAll('.view-report-btn').forEach(button => {
            button.addEventListener('click', function() {
                const reportModal = new bootstrap.Modal(document.getElementById('reportPreviewModal'));
                document.getElementById('reportPreviewContent').innerHTML = decodeURIComponent(this.dataset.html);
                reportModal.show();
            });
        });

        // Set default dates for reports
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

            document.getElementById("reportStartDate").value = firstDay.toISOString().split("T")[0];
            document.getElementById("reportEndDate").value = today.toISOString().split("T")[0];
        });
    </script>
</body>
</html>
