<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growth Tracking | BabyCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --baby-pink: #ffb6c1;
            --baby-blue: #89cff0;
            --baby-green: #98ff98;
            --baby-lavender: #e6e6fa;
        }

        body {
            background-color: #fff9f9;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .growth-header {
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

        .growth-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 30px;
        }

        .percentile-card {
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .percentile-value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .percentile-label {
            font-size: 0.9rem;
            color: #666;
        }

        .measurement-card {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--baby-pink);
        }

        .measurement-date {
            font-size: 0.8rem;
            color: #888;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #666;
            font-weight: 500;
            padding: 12px 20px;
        }

        .nav-tabs .nav-link.active {
            color: var(--baby-pink);
            border-bottom: 3px solid var(--baby-pink);
            background: transparent;
        }

        .tab-content {
            padding: 20px 0;
        }

        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }
        }
    </style>
</head>

<body>
    @php
        use App\Models\Baby;
        use Carbon\Carbon;

        $baby = Baby::where('id', Auth::id())->first();
    @endphp
    <div class="growth-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('baby.dashboard') }}" class="btn-back me-3"><i class="fas fa-arrow-left me-2"></i>
                        Dashboard</a>
                    <img src="https://cdn-icons-png.flaticon.com/512/1864/1864593.png" alt="Baby"
                        class="baby-avatar me-3">
                    <div>
                        <h2 class="mb-1 text-white">{{ $baby_name }}</h2>
                        <div class="d-flex align-items-center"><span class="text-white"><i
                                    class="fas fa-chart-line me-1"></i> Growth Tracking</span></div>
                    </div>
                </div>
                <div><span class="badge bg-white text-dark"><i class="fas fa-birthday-cake me-1"
                            style="color: var(--baby-pink)"></i>
                        {{ round(\Carbon\Carbon::parse($baby->birth_date)->floatDiffInMonths(now()), 1) }}
                        months old</span></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="growth-card">
            <ul class="nav nav-tabs" id="growthTab" role="tablist">
                <li class="nav-item" role="presentation"><button class="nav-link active" id="weight-tab"
                        data-bs-toggle="tab" data-bs-target="#weight" type="button" role="tab"><i
                            class="fas fa-weight me-1"></i> Weight</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="height-tab" data-bs-toggle="tab"
                        data-bs-target="#height" type="button" role="tab"><i
                            class="fas fa-ruler-vertical me-1"></i> Height</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="head-tab" data-bs-toggle="tab"
                        data-bs-target="#head" type="button" role="tab"><i class="fas fa-brain me-1"></i> Head
                        Circumference</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" id="bmi-tab" data-bs-toggle="tab"
                        data-bs-target="#bmi" type="button" role="tab"><i class="fas fa-calculator me-1"></i>
                        BMI</button></li>
            </ul>

            <div class="tab-content" id="growthTabContent">
                <div class="tab-pane fade show active" id="weight" role="tabpanel">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-container"><canvas id="weightChart"></canvas></div>
                        </div>
                        <div class="col-md-4">
                            <div class="percentile-card" style="background: rgba(255,182,193,0.1)">
                                <div class="percentile-value" style="color: var(--baby-pink)">
                                    {{ $latest_weight ? $latest_weight . ' kg' : 'N/A' }}</div>
                                <div class="percentile-label">Current Weight</div><small>{{ $latest_date }}</small>
                            </div>
                            <div class="percentile-card" style="background: rgba(152,255,152,0.1)">
                                <div class="percentile-value" style="color: var(--baby-green)">{{ $weight_percentile }}
                                </div>
                                <div class="percentile-label">Percentile</div><small>WHO Growth Standard</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="height" role="tabpanel">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-container"><canvas id="heightChart"></canvas></div>
                        </div>
                        <div class="col-md-4">
                            <div class="percentile-card" style="background: rgba(137,207,240,0.1)">
                                <div class="percentile-value" style="color: var(--baby-blue)">
                                    {{ $latest_height ? $latest_height . ' cm' : 'N/A' }}</div>
                                <div class="percentile-label">Current Height</div><small>{{ $latest_date }}</small>
                            </div>
                            <div class="percentile-card" style="background: rgba(152,255,152,0.1)">
                                <div class="percentile-value" style="color: var(--baby-green)">
                                    {{ $height_percentile }}</div>
                                <div class="percentile-label">Percentile</div><small>WHO Growth Standard</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="head" role="tabpanel">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-container"><canvas id="headChart"></canvas></div>
                        </div>
                        <div class="col-md-4">
                            <div class="percentile-card" style="background: rgba(230,230,250,0.3)">
                                <div class="percentile-value" style="color: var(--baby-pink)">
                                    {{ $latest_head_circumference ? $latest_head_circumference . ' cm' : 'N/A' }}</div>
                                <div class="percentile-label">Current Head Circ.</div>
                                <small>{{ $latest_date }}</small>
                            </div>
                            <div class="percentile-card" style="background: rgba(152,255,152,0.1)">
                                <div class="percentile-value" style="color: var(--baby-green)">{{ $head_percentile }}
                                </div>
                                <div class="percentile-label">Percentile</div><small>WHO Growth Standard</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="bmi" role="tabpanel">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-container"><canvas id="bmiChart"></canvas></div>
                        </div>
                        <div class="col-md-4">
                            <div class="percentile-card" style="background: rgba(201,160,220,0.1)">
                                <div class="percentile-value" style="color: var(--baby-lavender)">{{ $latest_bmi }}
                                </div>
                                <div class="percentile-label">Current BMI</div>
                                <div class="bmi-status bmi-normal mt-2">
                                    {{ $latest_bmi !== 'N/A' && $latest_bmi >= 14 && $latest_bmi <= 18 ? 'Normal Range' : 'Check with Pediatrician' }}
                                </div><small>{{ $latest_date }}</small>
                            </div>
                            <div class="percentile-card" style="background: rgba(152,255,152,0.1)">
                                <div class="percentile-value" style="color: var(--baby-green)">{{ $bmi_percentile }}
                                </div>
                                <div class="percentile-label">Percentile</div><small>WHO Growth Standard</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="growth-card">
            <h4 class="mb-3">Latest Clinic Details</h4>
            <div class="measurement-card">
                <div class="measurement-date">{{ $latest_date }}</div>
                <p><strong>Nutrition:</strong> {{ $latest_record->nutrition ?? 'N/A' }}</p>
                <p><strong>Vaccination:</strong> {{ $latest_record->vaccination_name ?? 'N/A' }}</p>
                <p><strong>Midwife Notes:</strong> {{ $latest_record->midwife_accommodations ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const chartLabels = @json($labels);
        const weightData = @json($weights);
        const heightData = @json($heights);
        const headData = @json($head_circumferences);
        const bmiData = @json($bmis);

        console.log('Labels:', chartLabels);
        console.log('Weight Data:', weightData);
        console.log('Height Data:', heightData);
        console.log('Head Data:', headData);
        console.log('BMI Data:', bmiData);

        function initializeChart(canvasId, label, data, borderColor, bgColor, percentile, yTitle, chartTitle, yMin) {
            if (!document.getElementById(canvasId)) {
                console.error(`Canvas ${canvasId} not found`);
                return;
            }
            if (!data || data.length === 0 || data.every(val => val === null)) {
                console.warn(`${chartTitle} has no valid data`);
                return;
            }
            try {
                new Chart(document.getElementById(canvasId).getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: label,
                            data: data,
                            borderColor: borderColor,
                            backgroundColor: bgColor,
                            borderWidth: 3,
                            tension: 0.3,
                            fill: true
                        }, {
                            label: '50th Percentile',
                            data: Array(chartLabels.length).fill(percentile),
                            borderColor: '#ddd',
                            borderWidth: 1,
                            borderDash: [5, 5],
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: chartTitle,
                                font: {
                                    size: 16
                                }
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                min: yMin,
                                title: {
                                    display: true,
                                    text: yTitle
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error(`Error initializing ${chartTitle}:`, error);
            }
        }

        initializeChart('weightChart', "{{ $baby_name }}'s Weight", weightData, '#ffb6c1', 'rgba(255,182,193,0.1)', 7.0,
            'Weight (kg)', 'Weight Growth Chart (kg)', 2);
        initializeChart('heightChart', "{{ $baby_name }}'s Height", heightData, '#89cff0', 'rgba(137,207,240,0.1)',
            66.0, 'Height (cm)', 'Height Growth Chart (cm)', 40);
        initializeChart('headChart', "{{ $baby_name }}'s Head Circumference", headData, '#e6e6fa',
            'rgba(230,230,250,0.2)', 43.0, 'Circumference (cm)', 'Head Circumference Chart (cm)', 30);
        initializeChart('bmiChart', "{{ $baby_name }}'s BMI", bmiData, '#c9a0dc', 'rgba(201,160,220,0.1)', 16.8,
            'BMI (kg/m²)', 'BMI Growth Chart', 12);
    </script>
</body>

</html>
