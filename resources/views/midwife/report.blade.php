<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Advanced Reports | Midwife Dashboard</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      :root {
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
      }

      /* Top Navigation Bar */
      .top-bar {
        background: linear-gradient(
          135deg,
          var(--gradient-start),
          var(--gradient-end)
        );
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

      /* Main Content */
      .main-content {
        padding: 25px;
        max-width: 1400px;
        margin: 0 auto;
      }

      /* Report Configuration Panel */
      .config-panel {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
      }

      .config-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 20px;
      }

      /* Report Cards */
      .report-card {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
      }

      .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
      }

      .report-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 0;
      }

      .report-period {
        color: #6c757d;
        font-size: 14px;
      }

      /* Progress Cards */
      .progress-card {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--teal);
      }

      .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
      }

      .progress-title {
        font-weight: 600;
        color: var(--navy);
      }

      .progress-value {
        font-weight: 700;
      }

      .progress-completed {
        color: #28a745;
      }

      .progress-pending {
        color: #ffc107;
      }

      .progress-bar-container {
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        margin-bottom: 5px;
      }

      .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        background-color: var(--teal);
      }

      .progress-details {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #6c757d;
      }

      /* Charts */
      .chart-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        height: 100%;
      }

      .chart-title {
        color: var(--teal-dark);
        font-weight: 600;
        margin-bottom: 15px;
      }

      /* Target Indicators */
      .target-indicator {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
      }

      .target-status {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
      }

      .status-achieved {
        background-color: #28a745;
      }

      .status-partial {
        background-color: #ffc107;
      }

      .status-missed {
        background-color: #dc3545;
      }

      /* Report Tables */
      .report-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
      }

      .report-table th {
        background-color: var(--teal);
        color: white;
        padding: 12px 15px;
        text-align: left;
      }

      .report-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
      }

      .report-table tr:hover td {
        background-color: #f8f9fa;
      }
.arrow a{
  text-decoration: none;
}
      /* Mobile Optimizations */
      @media (max-width: 768px) {
        .top-bar {
          padding: 12px 0;
        }

        .back-btn {
          padding: 6px 12px;
          font-size: 13px;
        }

        .report-header {
          flex-direction: column;
          align-items: flex-start;
        }

        .report-period {
          margin-top: 5px;
        }

        .report-table th,
        .report-table td {
          padding: 8px 10px;
          font-size: 14px;
        }
      }
    </style>
  </head>
  <body>
    <!-- Top Navigation Bar -->
    <div class="top-bar">
      <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center arrow">
            <a href="dash.html" class="back-btn me-3">
              <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h5 class="mb-0 d-none d-md-block text-white">
              Advanced Reporting
            </h5>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Report Configuration -->
      <div class="config-panel">
        <h5 class="config-title">Generate Custom Report</h5>
        <form id="reportConfigForm">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Report Type</label>
              <select class="form-select" id="reportType" required>
                <option value="">Select report type</option>
                <option value="performance">Performance Report</option>
                <option value="clinical">Clinical Activity Report</option>
                <option value="vaccination">Vaccination Report</option>
                <option value="nutrition">Nutrition Report</option>
                <option value="targets">Target Achievement Report</option>
                <option value="custom">Custom Report</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label">Time Period</label>
              <select class="form-select" id="timePeriod" required>
                <option value="week">Weekly</option>
                <option value="month" selected>Monthly</option>
                <option value="quarter">Quarterly</option>
                <option value="year">Annual</option>
                <option value="custom">Custom Range</option>
              </select>
            </div>
            <div class="col-md-4" id="customDateRange" style="display: none">
              <label class="form-label">Date Range</label>
              <div class="input-group">
                <input type="date" class="form-control" id="startDate" />
                <span class="input-group-text">to</span>
                <input type="date" class="form-control" id="endDate" />
              </div>
            </div>
          </div>
          <div class="row g-3 mt-2" id="reportOptions" style="display: none">
            <div class="col-md-12">
              <label class="form-label">Report Options</label>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="optVaccinations"
                />
                <label class="form-check-label" for="optVaccinations">
                  Include Vaccination Data
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="optNutrition"
                />
                <label class="form-check-label" for="optNutrition">
                  Include Nutrition Data
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="optVisits"
                />
                <label class="form-check-label" for="optVisits">
                  Include Visit Statistics
                </label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="optTargets"
                />
                <label class="form-check-label" for="optTargets">
                  Include Target Progress
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">
            <i class="fas fa-chart-bar me-1"></i> Generate Report
          </button>
        </form>
      </div>

      <!-- Generated Report View -->
      <div id="generatedReport">
        <!-- Report Header -->
        <div class="report-card">
          <div class="report-header">
            <h1 class="report-title" id="dynamicReportTitle">
              Monthly Performance Report
            </h1>
            <div class="report-period" id="reportDateRange">
              June 1 - 30, 2023
            </div>
          </div>

          <!-- Progress Summary -->
          <div class="row mb-4">
            <div class="col-md-6">
              <h5 class="chart-title">Monthly Progress</h5>
              <div class="progress-card">
                <div class="progress-header">
                  <span class="progress-title">Vaccination Target</span>
                  <span class="progress-value progress-completed">92%</span>
                </div>
                <div class="progress-bar-container">
                  <div class="progress-bar-fill" style="width: 92%"></div>
                </div>
                <div class="progress-details">
                  <span>24/26 babies vaccinated</span>
                  <span>Target: 100%</span>
                </div>
              </div>
              <div class="progress-card">
                <div class="progress-header">
                  <span class="progress-title">Prenatal Visits</span>
                  <span class="progress-value progress-completed">100%</span>
                </div>
                <div class="progress-bar-container">
                  <div class="progress-bar-fill" style="width: 100%"></div>
                </div>
                <div class="progress-details">
                  <span>18/18 mothers attended</span>
                  <span>Target: 95%</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h5 class="chart-title">Target Achievement</h5>
              <div class="target-indicator">
                <span class="target-status status-achieved"></span>
                <span>Vaccination coverage (Exceeded target by 7%)</span>
              </div>
              <div class="target-indicator">
                <span class="target-status status-achieved"></span>
                <span>Prenatal care visits (100% completed)</span>
              </div>
              <div class="target-indicator">
                <span class="target-status status-partial"></span>
                <span>Thriposha distribution (85% of target)</span>
              </div>
              <div class="target-indicator">
                <span class="target-status status-missed"></span>
                <span>Field visits (12/15 completed)</span>
              </div>
              <div class="target-indicator">
                <span class="target-status status-achieved"></span>
                <span>Newborn registrations (8/8 target)</span>
              </div>
            </div>
          </div>

          <!-- Charts Row -->
          <div class="row mb-4">
            <div class="col-lg-6">
              <div class="chart-container">
                <h5 class="chart-title">Weekly Activity Breakdown</h5>
                <canvas id="activityChart"></canvas>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="chart-container">
                <h5 class="chart-title">Target Achievement</h5>
                <canvas id="targetsChart"></canvas>
              </div>
            </div>
          </div>

          <!-- Detailed Reports -->
          <div class="row">
            <div class="col-lg-6">
              <div class="report-card">
                <h5 class="chart-title">Activity Summary</h5>
                <div class="table-responsive">
                  <table class="report-table">
                    <thead>
                      <tr>
                        <th>Activity</th>
                        <th>Count</th>
                        <th>Target</th>
                        <th>Progress</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Clinic Days</td>
                        <td>18</td>
                        <td>20</td>
                        <td>
                          <div class="progress" style="height: 8px">
                            <div
                              class="progress-bar bg-warning"
                              style="width: 90%"
                            ></div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Field Visits</td>
                        <td>12</td>
                        <td>15</td>
                        <td>
                          <div class="progress" style="height: 8px">
                            <div
                              class="progress-bar bg-danger"
                              style="width: 80%"
                            ></div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Baby Checkups</td>
                        <td>42</td>
                        <td>45</td>
                        <td>
                          <div class="progress" style="height: 8px">
                            <div
                              class="progress-bar bg-success"
                              style="width: 93%"
                            ></div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Prenatal Visits</td>
                        <td>18</td>
                        <td>18</td>
                        <td>
                          <div class="progress" style="height: 8px">
                            <div
                              class="progress-bar bg-success"
                              style="width: 100%"
                            ></div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="report-card">
                <h5 class="chart-title">Performance Metrics</h5>
                <div class="table-responsive">
                  <table class="report-table">
                    <thead>
                      <tr>
                        <th>Metric</th>
                        <th>This Period</th>
                        <th>Last Period</th>
                        <th>Change</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>New Registrations</td>
                        <td>8</td>
                        <td>7</td>
                        <td class="text-success">
                          +14% <i class="fas fa-arrow-up"></i>
                        </td>
                      </tr>
                      <tr>
                        <td>Vaccinations</td>
                        <td>25</td>
                        <td>22</td>
                        <td class="text-success">
                          +14% <i class="fas fa-arrow-up"></i>
                        </td>
                      </tr>
                      <tr>
                        <td>Thriposha Distributed</td>
                        <td>42</td>
                        <td>38</td>
                        <td class="text-success">
                          +11% <i class="fas fa-arrow-up"></i>
                        </td>
                      </tr>
                      <tr>
                        <td>High-Risk Cases</td>
                        <td>4</td>
                        <td>5</td>
                        <td class="text-danger">
                          -20% <i class="fas fa-arrow-down"></i>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Report Actions -->
          <div class="report-card text-center">
            <button class="btn btn-primary me-2" id="exportPdf">
              <i class="fas fa-file-pdf me-1"></i> Export as PDF
            </button>
            <button class="btn btn-outline-secondary me-2" id="printReport">
              <i class="fas fa-print me-1"></i> Print Report
            </button>
            <button class="btn btn-outline-primary" id="saveReport">
              <i class="fas fa-save me-1"></i> Save Report
            </button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Initialize Charts
      document.addEventListener("DOMContentLoaded", function () {
        // Activity Chart
        const activityCtx = document
          .getElementById("activityChart")
          .getContext("2d");
        const activityChart = new Chart(activityCtx, {
          type: "bar",
          data: {
            labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
            datasets: [
              {
                label: "Clinic Visits",
                data: [15, 18, 20, 17],
                backgroundColor: "rgba(43, 124, 133, 0.7)",
                borderColor: "rgba(43, 124, 133, 1)",
                borderWidth: 1,
              },
              {
                label: "Field Visits",
                data: [3, 4, 3, 2],
                backgroundColor: "rgba(23, 88, 115, 0.7)",
                borderColor: "rgba(23, 88, 115, 1)",
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: "Number of Visits",
                },
              },
            },
          },
        });

        // Targets Chart
        const targetsCtx = document
          .getElementById("targetsChart")
          .getContext("2d");
        const targetsChart = new Chart(targetsCtx, {
          type: "doughnut",
          data: {
            labels: ["Achieved", "Partial", "Missed"],
            datasets: [
              {
                data: [3, 1, 1],
                backgroundColor: ["#28a745", "#ffc107", "#dc3545"],
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
      });

      // Show/hide custom date range based on selection
      document
        .getElementById("timePeriod")
        .addEventListener("change", function () {
          const customRange = document.getElementById("customDateRange");
          customRange.style.display =
            this.value === "custom" ? "block" : "none";
        });

      // Show report options when custom report is selected
      document
        .getElementById("reportType")
        .addEventListener("change", function () {
          const reportOptions = document.getElementById("reportOptions");
          reportOptions.style.display =
            this.value === "custom" ? "block" : "none";
        });

      // Form submission handler
      document
        .getElementById("reportConfigForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          // Get form values
          const reportType = document.getElementById("reportType").value;
          const timePeriod = document.getElementById("timePeriod").value;

          // Update report title based on selections
          const reportTitle = document.getElementById("dynamicReportTitle");
          const dateRange = document.getElementById("reportDateRange");

          let typeText = "";
          switch (reportType) {
            case "performance":
              typeText = "Performance";
              break;
            case "clinical":
              typeText = "Clinical Activity";
              break;
            case "vaccination":
              typeText = "Vaccination";
              break;
            case "nutrition":
              typeText = "Nutrition";
              break;
            case "targets":
              typeText = "Target Achievement";
              break;
            case "custom":
              typeText = "Custom";
              break;
            default:
              typeText = "Performance";
          }

          let periodText = "";
          switch (timePeriod) {
            case "week":
              periodText = "Weekly";
              dateRange.textContent = "June 19-25, 2023";
              break;
            case "month":
              periodText = "Monthly";
              dateRange.textContent = "June 1-30, 2023";
              break;
            case "quarter":
              periodText = "Quarterly";
              dateRange.textContent = "April 1 - June 30, 2023";
              break;
            case "year":
              periodText = "Annual";
              dateRange.textContent = "January 1 - December 31, 2023";
              break;
            case "custom":
              periodText = "Custom";
              const startDate = document.getElementById("startDate").value;
              const endDate = document.getElementById("endDate").value;
              dateRange.textContent = `${startDate} to ${endDate}`;
              break;
          }

          reportTitle.textContent = `${periodText} ${typeText} Report`;

          // Scroll to generated report
          document.getElementById("generatedReport").scrollIntoView();
        });

      // Button actions
      document
        .getElementById("exportPdf")
        .addEventListener("click", function () {
          alert("PDF export functionality would be implemented here");
        });

      document
        .getElementById("printReport")
        .addEventListener("click", function () {
          alert("Print functionality would be implemented here");
        });

      document
        .getElementById("saveReport")
        .addEventListener("click", function () {
          alert("Report would be saved to your dashboard");
        });
    </script>
  </body>
</html>
