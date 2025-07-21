<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daily Diary | Midwife Dashboard</title>
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

      /* Diary Card */
      .diary-card {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
      }

      .diary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
      }

      .diary-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 0;
      }

      .diary-date {
        color: #6c757d;
        font-size: 14px;
      }

      /* Activity Selection */
      .activity-options {
        margin-bottom: 20px;
      }

      .activity-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
      }

      .activity-tab {
        padding: 8px 15px;
        border-radius: 20px;
        background-color: #e9ecef;
        color: #495057;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
      }

      .activity-tab.active {
        background-color: var(--teal);
        color: white;
      }

      .activity-tab:hover:not(.active) {
        background-color: #dee2e6;
      }

      /* Patient Selection */
      .patient-selection {
        margin-bottom: 20px;
      }

      .patient-list {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 8px;
      }

      .patient-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
      }

      .patient-item:last-child {
        border-bottom: none;
      }

      .patient-item:hover {
        background-color: #f8f9fa;
      }

      .patient-info {
        flex-grow: 1;
      }

      .patient-name {
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 3px;
      }

      .patient-details {
        font-size: 13px;
        color: #6c757d;
      }

      /* Service Details */
      .service-details {
        margin-bottom: 20px;
      }

      .service-section {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
      }

      .service-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
      }

      .service-title {
        font-weight: 600;
        color: var(--teal-dark);
        margin-bottom: 10px;
      }

      /* Notes Section */
      .notes-section textarea {
        min-height: 100px;
      }

      /* Summary Section */
      .summary-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
      }

      .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
      }

      .summary-label {
        font-weight: 500;
        color: #495057;
      }

      .summary-value {
        font-weight: 600;
        color: var(--navy);
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

        .diary-header {
          flex-direction: column;
          align-items: flex-start;
        }

        .diary-date {
          margin-top: 5px;
        }

        .activity-tabs {
          gap: 5px;
        }

        .activity-tab {
          padding: 6px 12px;
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
            <h5 class="mb-0 d-none d-md-block text-white">Daily Diary</h5>
          </div>
          <div class="d-flex align-items-center">
            <div class="text-white me-3">
              <i class="far fa-calendar me-2"></i>
              <span id="currentDate">June 25, 2023</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="diary-card">
        <div class="diary-header">
          <h1 class="diary-title">Daily Activities</h1>
          <div class="diary-date" id="diaryDate">Sunday, June 25, 2023</div>
        </div>

        <!-- Activity Selection -->
        <div class="activity-options">
          <h5 class="service-title">Select Activity Type</h5>
          <div class="activity-tabs">
            <button class="activity-tab active" data-activity="clinic">
              <i class="fas fa-clinic-medical me-1"></i> Clinic Day
            </button>
            <button class="activity-tab" data-activity="vaccination">
              <i class="fas fa-syringe me-1"></i> Vaccination
            </button>
            <button class="activity-tab" data-activity="field">
              <i class="fas fa-home me-1"></i> Field Visit
            </button>
            <button class="activity-tab" data-activity="prenatal">
              <i class="fas fa-female me-1"></i> Prenatal Care
            </button>
            <button class="activity-tab" data-activity="other">
              <i class="fas fa-tasks me-1"></i> Other Activities
            </button>
          </div>
        </div>

        <!-- Patient Selection -->
        <div class="patient-selection">
          <h5 class="service-title">Patients Served Today</h5>
          <div class="patient-list">
            <div class="patient-item">
              <div class="form-check me-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="patient1"
                  checked
                />
              </div>
              <div class="patient-info">
                <div class="patient-name">Emma Johnson</div>
                <div class="patient-details">Baby (3 months) | ID: B-1001</div>
              </div>
              <div class="badge bg-primary">Vaccination</div>
            </div>
            <div class="patient-item">
              <div class="form-check me-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="patient2"
                  checked
                />
              </div>
              <div class="patient-info">
                <div class="patient-name">Sarah Johnson</div>
                <div class="patient-details">
                  Mother (36 weeks) | ID: PW-2001
                </div>
              </div>
              <div class="badge bg-success">Prenatal</div>
            </div>
            <div class="patient-item">
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" id="patient3" />
              </div>
              <div class="patient-info">
                <div class="patient-name">Liam Garcia</div>
                <div class="patient-details">Baby (5 months) | ID: B-1002</div>
              </div>
              <div class="badge bg-warning text-dark">Checkup</div>
            </div>
            <div class="patient-item">
              <div class="form-check me-3">
                <input class="form-check-input" type="checkbox" id="patient4" />
              </div>
              <div class="patient-info">
                <div class="patient-name">Maria Garcia</div>
                <div class="patient-details">
                  Mother (28 weeks) | ID: PW-2002
                </div>
              </div>
              <div class="badge bg-info">Follow-up</div>
            </div>
            <div class="patient-item">
              <div class="form-check me-3">
                <input
                  class="form-check-input"
                  type="checkbox"
                  id="patient5"
                  checked
                />
              </div>
              <div class="patient-info">
                <div class="patient-name">Noah Wong</div>
                <div class="patient-details">Baby (6 months) | ID: B-1005</div>
              </div>
              <div class="badge bg-danger">Nutrition</div>
            </div>
          </div>
        </div>

        <!-- Service Details -->
        <div class="service-details">
          <h5 class="service-title">Service Details</h5>

          <!-- Vaccination Section -->
          <div class="service-section" id="vaccinationSection">
            <h6>
              <i class="fas fa-syringe me-2"></i> Vaccinations Administered
            </h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Vaccine Type</label>
                <select class="form-select">
                  <option value="">Select vaccine</option>
                  <option selected>BCG</option>
                  <option>Pentavalent 1</option>
                  <option>Pentavalent 2</option>
                  <option>Pentavalent 3</option>
                  <option>MMR</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Number of Doses</label>
                <input type="number" class="form-control" value="3" />
              </div>
            </div>
          </div>

          <!-- Health Checkup Section -->
          <div class="service-section" id="checkupSection">
            <h6><i class="fas fa-heartbeat me-2"></i> Health Checkups</h6>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Babies Checked</label>
                <input type="number" class="form-control" value="5" />
              </div>
              <div class="col-md-4">
                <label class="form-label">Mothers Checked</label>
                <input type="number" class="form-control" value="2" />
              </div>
              <div class="col-md-4">
                <label class="form-label">Referrals Made</label>
                <input type="number" class="form-control" value="1" />
              </div>
            </div>
          </div>

          <!-- Field Visit Section -->
          <div class="service-section" id="fieldSection">
            <h6><i class="fas fa-home me-2"></i> Field Visits</h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Houses Visited</label>
                <input type="number" class="form-control" value="8" />
              </div>
              <div class="col-md-6">
                <label class="form-label">New Cases Identified</label>
                <input type="number" class="form-control" value="2" />
              </div>
            </div>
          </div>

          <!-- Thriposha Distribution -->
          <div class="service-section" id="thriposhaSection">
            <h6>
              <i class="fas fa-utensils me-2"></i> Nutrition Supplementation
            </h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Baby Thriposha Packs</label>
                <input type="number" class="form-control" value="5" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Mother Thriposha Packs</label>
                <input type="number" class="form-control" value="3" />
              </div>
            </div>
          </div>
        </div>

        <!-- Notes Section -->
        <div class="notes-section">
          <h5 class="service-title">Daily Notes</h5>
          <textarea
            class="form-control"
            placeholder="Enter any important notes from today's activities..."
          >
- Emma Johnson completed BCG vaccination
- Sarah Johnson had elevated BP (140/90), advised to rest
- Field visit to 8 houses in Grama Niladhari Division 12
- Distributed 5 baby Thriposha and 3 mother Thriposha packs</textarea
          >
        </div>

        <!-- Daily Summary -->
        <div class="summary-card">
          <h5 class="service-title">Today's Summary</h5>
          <div class="summary-item">
            <span class="summary-label">Total Patients Served:</span>
            <span class="summary-value">8</span>
          </div>
          <div class="summary-item">
            <span class="summary-label">Vaccinations Given:</span>
            <span class="summary-value">3</span>
          </div>
          <div class="summary-item">
            <span class="summary-label">Health Checkups:</span>
            <span class="summary-value">7</span>
          </div>
          <div class="summary-item">
            <span class="summary-label">Field Visits:</span>
            <span class="summary-value">8 houses</span>
          </div>
          <div class="summary-item">
            <span class="summary-label">Thriposha Distributed:</span>
            <span class="summary-value">8 packs</span>
          </div>
        </div>

        <!-- Save Button -->
        <div class="d-grid gap-2 mt-4">
          <button class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Save Daily Diary
          </button>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Set current date
      document.addEventListener("DOMContentLoaded", function () {
        const now = new Date();
        const options = {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
        };
        document.getElementById("currentDate").textContent =
          now.toLocaleDateString("en-US", {
            year: "numeric",
            month: "long",
            day: "numeric",
          });
        document.getElementById("diaryDate").textContent =
          now.toLocaleDateString("en-US", options);
      });

      // Activity tab switching
      document.querySelectorAll(".activity-tab").forEach((tab) => {
        tab.addEventListener("click", function () {
          document
            .querySelectorAll(".activity-tab")
            .forEach((t) => t.classList.remove("active"));
          this.classList.add("active");

          // In a real app, you would show/hide relevant sections based on activity type
        });
      });

      // Patient selection
      document
        .querySelectorAll(".patient-list .form-check-input")
        .forEach((checkbox) => {
          checkbox.addEventListener("change", function () {
            const patientItem = this.closest(".patient-item");
            if (this.checked) {
              patientItem.style.backgroundColor = "#f8f9fa";
            } else {
              patientItem.style.backgroundColor = "white";
            }
            updateSummary();
          });
        });

      // Update summary counts
      function updateSummary() {
        // In a real app, this would calculate based on actual data
        const patientCount = document.querySelectorAll(
          ".patient-list .form-check-input:checked"
        ).length;
        document.querySelector(
          ".summary-item:nth-child(1) .summary-value"
        ).textContent = patientCount;
      }

      // Initialize with some data
      updateSummary();
    </script>
  </body>
</html>
