<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vaccination Record | BabyCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Comic+Neue:wght@400;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --baby-pink: #ffb6c1;
            --baby-blue: #89cff0;
            --baby-green: #98ff98;
            --baby-lavender: #e6e6fa;
            --header-gradient: linear-gradient(135deg,
                    var(--baby-pink),
                    var(--baby-blue));
        }

        body {
            background-color: #fff9f9;
            font-family: "Comic Neue", "Poppins", sans-serif;
        }

        .vaccine-header {
            background: linear-gradient(135deg, #B6E5D8, var(--baby-blue));
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

        .vaccine-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .vaccine-table {
            width: 100%;
            border-collapse: collapse;
        }

        .vaccine-table thead th {
            background-color: var(--baby-pink);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .vaccine-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        .vaccine-table tbody tr:nth-child(even) {
            background-color: var(--baby-lavender);
        }

        .vaccine-table tbody tr:hover {
            background-color: rgba(255, 182, 193, 0.1);
        }

        .vaccine-table td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .completed {
            background-color: var(--baby-green);
            color: #1a6b1a;
        }

        .pending {
            background-color: #fffacd;
            color: #8a6d3b;
        }

        .missed {
            background-color: #ffd1d1;
            color: #a94442;
        }

        .vaccine-icon {
            color: var(--baby-pink);
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .btn-add {
            background: var(--header-gradient);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
            margin-bottom: 50px;
            margin-left: 40%;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn_back {
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

        .btn_back :hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        @media (max-width: 768px) {
            .vaccine-table thead {
                display: none;
            }

            .vaccine-table,
            .vaccine-table tbody,
            .vaccine-table tr,
            .vaccine-table td {
                display: block;
                width: 100%;
            }

            .vaccine-table tr {
                margin-bottom: 15px;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .vaccine-table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid #f0f0f0;
            }

            .vaccine-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: calc(50% - 15px);
                padding-right: 10px;
                font-weight: 600;
                text-align: left;
                color: var(--baby-pink);
            }


        }
    </style>
</head>

<body>
    @php
        use App\Models\Baby;
        use Carbon\Carbon;

        $baby = Baby::where('id', Auth::id())->first();

        $date = null;

    @endphp
    <!-- Header Section -->
    <div class="vaccine-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <a href="{{ route('dashboard') }}" class="btn_back me-3">
                        <i class="fas fa-arrow-left me-2"></i> Dashboard
                    </a>
                    <img src="https://cdn-icons-png.flaticon.com/512/1864/1864593.png" alt="Baby"
                        class="baby-avatar me-3" />
                    <div>

                        <h2 class="mb-1 text-white">{{ $baby->name }}</h2>
                        <div class="d-flex align-items-center">
                            <span class="text-white">
                                <i class="fas fa-syringe me-1"></i>
                                Vaccination Record
                            </span>
                        </div>
                    </div>
                </div>
                <div>





                    <span class="badge bg-white text-dark">
                        <i class="fas fa-birthday-cake me-1" style="color: var(--baby-pink)"></i>
                        {{ round(\Carbon\Carbon::parse($baby->birth_date)->floatDiffInMonths(now()), 1) }}
                        months old
                    </span>

                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="vaccine-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-history me-2" style="color: var(--baby-pink)"></i>
                    Vaccination History
                </h3>

            </div>

            <div class="table-responsive">
                <table class="vaccine-table">
                    <thead>
                        <tr>
                            <th>Vaccine Name</th>
                            <th>Date Administered</th>
                            <th>Recommended Age</th>
                            <th>Dose</th>
                            <th>Status</th>
                            <th>Administered By</th>
                            <th>Clinic/Hospital</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vaccinations as $vaccine)
                            <tr>
                                <td data-label="Vaccine Name">
                                    <i class="fas fa-syringe vaccine-icon"></i>
                                    {{ $vaccine->vaccine_name }}
                                </td>
                                <td data-label="Date Administered">
                                    @php
                                       

                                        if ($vaccine->date_administered) {
                                            $date = Carbon::parse($vaccine->date_administered);
                                        } elseif ($vaccine->recommended_age && $baby->birth_date) {
                                            $birthDate = Carbon::parse($baby->birth_date);
                                            $age = strtolower($vaccine->recommended_age);

                                            if (str_contains($age, 'week')) {
                                                preg_match('/\d+/', $age, $match);
                                                $date = $birthDate->addWeeks((int) $match[0]);
                                            } elseif (str_contains($age, 'month')) {
                                                preg_match('/\d+/', $age, $match);
                                                $date = $birthDate->addMonths((int) $match[0]);
                                            }
                                        }
                                    @endphp

                                    {{ $date ? $date->format('M d, Y') : '' }}
                                </td>

                                </td>
                                <td data-label="Recommended Age">{{ $vaccine->recommended_age }}</td>
                                <td data-label="Dose">{{ $vaccine->dose }}</td>
                                <td data-label="Status">
                                    <span class="status-badge {{ strtolower($vaccine->status) }}">
                                        @php $status = strtolower($vaccine->status); @endphp

                                        @if ($status === 'completed')
                                            <i class="fas fa-check me-1"></i>
                                        @elseif($status === 'pending')
                                            <i class="fas fa-clock me-1"></i>
                                        @else
                                            <i class="fas fa-times me-1"></i>
                                        @endif

                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td data-label="Administered By">{{ $vaccine->administered_by ?? '-' }}</td>
                                <td data-label="Clinic/Hospital">{{ $vaccine->clinic ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
