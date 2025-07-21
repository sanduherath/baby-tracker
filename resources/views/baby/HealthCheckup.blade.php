<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Health Checkups | BabyCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        :root {
            --baby-pink: #ffb6c1;
            --baby-blue: #89cff0;
            --baby-green: #98ff98;
            --baby-lavender: #e6e6fa;
            --header-gradient: linear-gradient(135deg, var(--baby-pink), var(--baby-blue));
        }

        body {
            background-color: #fff9f9;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .checkup-header {
            background: linear-gradient(135deg, #b6e5d8, var(--baby-blue));
            color: white;
            border-radius: 0 0 25px 25px;
            padding: 20px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .baby-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            border-radius: 50px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .checkup-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .checkup-item {
            border-left: 4px solid var(--baby-pink);
            padding: 20px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 0 10px 10px 0;
            transition: all 0.3s;
        }

        .checkup-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .checkup-item.highlighted {
            background: #e6e6fa;
            border-left-color: var(--baby-blue);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .checkup-date {
            background: var(--baby-pink);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }

        .checkup-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .metric-card {
            background: var(--baby-lavender);
            padding: 12px;
            border-radius: 10px;
            text-align: center;
        }

        .metric-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--baby-pink);
            margin-bottom: 5px;
        }

        .metric-label {
            font-size: 0.8rem;
            color: #666;
        }

        .doctor-note {
            background: #f8f9fa;
            border-left: 3px solid var(--baby-blue);
            padding: 15px;
            margin-top: 15px;
            border-radius: 0 5px 5px 0;
            font-style: italic;
        }

        .btn-section {
            background: var(--header-gradient);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
            margin-right: 10px;
        }

        .btn-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-section.active {
            background: var(--baby-blue);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #888;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--baby-blue);
            margin-bottom: 15px;
        }

        .section-content {
            display: none;
        }

        .section-content.active {
            display: block;
        }

        @media (max-width: 768px) {
            .checkup-metrics {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<script>
    @if (isset($highlightedAppointmentId))
        document.addEventListener('DOMContentLoaded', function() {
            const highlighted = document.getElementById('appointment-{{ $highlightedAppointmentId }}');
            if (highlighted) {
                highlighted.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    @endif
</script>

<body>
    <!-- Header Section -->
    <div class="checkup-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('dashboard') }}" class="btn-back me-3">
                        <i class="fas fa-arrow-left me-2"></i> Dashboard
                    </a>
                    <img src="https://cdn-icons-png.flaticon.com/512/1864/1864593.png" alt="Baby"
                        class="baby-avatar me-3" />
                    <div>
                        <h2 class="mb-1 text-white">{{ $baby->name ?? 'Baby Name' }}</h2>
                        <div class="d-flex align-items-center">
                            <span class="text-white">
                                <i class="fas fa-heartbeat me-1"></i>
                                Health Checkup History
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="badge bg-white text-dark">
                        <i class="fas fa-birthday-cake me-1" style="color: var(--baby-pink)"></i>
                        {{ round(\Carbon\Carbon::parse($baby->birth_date)->floatDiffInMonths(now()), 1) }}
                        months old </span>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="checkup-card">
            <div class="d-flex justify-content-start align-items-center mb-4">
                <button class="btn-section active" onclick="showSection('upcoming')">
                    <i class="fas fa-calendar-check me-1"></i> Upcoming Checkups
                </button>
                <button class="btn-section" onclick="showSection('history')">
                    <i class="fas fa-history me-1"></i> Checkup History
                </button>
            </div>

            <!-- Upcoming Checkups Section -->
            <div id="upcoming-section" class="section-content active">
                @if ($upcomingAppointments->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <p>No upcoming checkups scheduled.</p>
                    </div>
                @else
                    @foreach ($upcomingAppointments as $index => $appointment)
                        <div class="checkup-item {{ $highlightedAppointmentId && $appointment->id == $highlightedAppointmentId ? 'highlighted' : '' }}"
                            id="appointment-{{ $appointment->id }}">
                            <span class="checkup-date"
                                style="background: {{ $index % 2 == 0 ? 'var(--baby-blue)' : 'var(--baby-green)' }}">
                                <i class="fas fa-calendar-check me-1"></i>
                                {{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}
                            </span>
                            <h5>{{ ucfirst($appointment->type) }}
                                {{ $appointment->type == 'vaccination' && $appointment->vaccination_type ? '(' . $appointment->vaccination_type . ')' : '' }}
                            </h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-user-md me-1" style="color: var(--baby-blue)"></i>
                                {{ $appointment->midwife->name ?? 'Unknown Midwife' }} -
                                {{ $appointment->midwife->phm_area ?? 'Unknown Area' }}
                            </p>
                            <div class="alert {{ $appointment->time ? 'alert-info' : 'alert-warning' }} mt-3">
                                <i class="fas {{ $appointment->time ? 'fa-bell' : 'fa-clock' }} me-2"></i>
                                {{ $appointment->time ? 'Scheduled at ' . \Carbon\Carbon::parse($appointment->time)->format('h:i A') : 'Time not scheduled' }}
                            </div>
                            @if ($appointment->notes)
                                <div class="doctor-note">
                                    <strong>Notes:</strong> {{ $appointment->notes }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Checkup History Section -->
            <div id="history-section" class="section-content">
                @if ($historyRecords->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-history"></i>
                        <p>No checkup history available.</p>
                    </div>
                @else
                    @foreach ($historyRecords as $record)
                        <div class="checkup-item">
                            <span class="checkup-date">
                                <i class="fas fa-calendar-day me-1"></i>
                                {{ \Carbon\Carbon::parse($record->created_at)->format('F d, Y') }}
                            </span>
                            <h5>Checkup
                                @if ($record->vaccination_name)
                                    (Vaccination: {{ $record->vaccination_name }})
                                @endif
                            </h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-clinic-medical me-1" style="color: var(--baby-blue)"></i>
                                Pediatric Care Center
                            </p>
                            <div class="checkup-metrics">
                                <div class="metric-card">
                                    <div class="metric-value">{{ $record->weight ?? 'N/A' }} kg</div>
                                    <div class="metric-label">Weight</div>
                                </div>
                                <div class="metric-card">
                                    <div class="metric-value">{{ $record->height ?? 'N/A' }} cm</div>
                                    <div class="metric-label">Length</div>
                                </div>
                                <div class="metric-card">
                                    <div class="metric-value">{{ $record->head_circumference ?? 'N/A' }} cm</div>
                                    <div class="metric-label">Head Circ.</div>
                                </div>
                                <div class="metric-card">
                                    <div class="metric-value">{{ $record->temperature ?? 'N/A' }}°F</div>
                                    <div class="metric-label">Temperature</div>
                                </div>
                            </div>
                            @if ($record->midwife_accommodations)
                                <div class="doctor-note">
                                    <strong>Notes:</strong> {{ $record->midwife_accommodations }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.remove('active');
            });
            document.querySelectorAll('.btn-section').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(`${sectionId}-section`).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        // Scroll to highlighted appointment
        @if ($highlightedAppointmentId)
            document.addEventListener('DOMContentLoaded', () => {
                const highlighted = document.getElementById('appointment-{{ $highlightedAppointmentId }}');
                if (highlighted) {
                    highlighted.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
