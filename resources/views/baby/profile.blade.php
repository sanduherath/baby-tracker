<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baby Profile | BabyCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
     <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Comic+Neue:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <style>
        :root {
            --baby-pink: #ffb6c1;
            --baby-blue: #89cff0;
            --baby-green: #98ff98;
            --baby-purple: #d8bfd8;
            --header-gradient: linear-gradient(135deg,
                    var(--baby-pink),
                    var(--baby-blue));
        }

        body {
            background-color: #fafafa;
        font-family: "Comic Neue", "Poppins", sans-serif;
        }

        .profile-header {
            background: linear-gradient(135deg, #B6E5D8, var(--baby-blue));
            color: white;
            padding: 2rem 0;
            border-radius: 0 0 25px 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-header h1 {
            font-size: 30px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border: 4px solid white;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .profile-card {
            background: #B6E2D3;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background-color: rgba(255, 182, 193, 0.1);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            color: #EF7C8E;
            font-weight: 600;
            margin: 0;
            font-size: 1.2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1rem;
            padding: 1.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            display: flex;
            align-items: center;
        }

        .info-label i {
            margin-right: 0.5rem;
            color: var(--baby-blue);
            width: 20px;
            text-align: center;
        }

        .info-value {
            color: #333;
            padding: 0.5rem 0;
        }

        .badge-gender {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-girl {
            background-color: #ffd1dc;
            color: #d35d6e;
        }

        .badge-boy {
            background-color: #add8e6;
            color: #1e6f9f;
        }

        .blood-group {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #3D5B59;
            color: white;
            font-weight: bold;
            font-size: 1rem;
        }

        .btn-edit {
            background-color: var(--baby-green);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-back {
            background: var(--header-gradient);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 1.8rem;
            font-weight: 600;
            margin-top: 1rem;
            transition: all 0.3s;
        }

        .contact-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            background-color: var(--baby-purple);
            color: #5a4a42;
            font-size: 0.8rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .info-label {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="profile-header">
        <div class="container">
            <div class="text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/1864/1864593.png" alt="Baby"
                    class="profile-avatar mb-3" />
                <h1 class="mb-2">Baby {{ $baby->name }}</h1>
                <p class="mb-0">
                    <i class="fas fa-birthday-cake me-1"></i>
                    Born: {{ \Carbon\Carbon::parse($baby->birth_date)->format('F d, Y') }} •
                    {{ round(\Carbon\Carbon::parse($baby->birth_date)->diffInDays(now()) / 30.44, 1) }} months old
                </p>

            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Personal Details Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-id-card me-2"></i>Personal Details
                </h2>
            </div>

            <div class="info-grid">
                <div class="info-label">
                    <i class="fas fa-signature"></i> Full Name
                </div>
                <div class="info-value">{{ $baby->name }}</div>

                <div class="info-label">
                    <i class="fas fa-calendar-day"></i> Date of Birth
                </div>
                <div class="info-value">{{ \Carbon\Carbon::parse($baby->birth_date)->format('F d, Y') }}</div>

                <div class="info-label">
                    <i class="fas fa-clock"></i> Time of Birth
                </div>
                <div class="info-value">
                    @if ($baby->birth_time)
                        {{ \Carbon\Carbon::parse($baby->birth_time)->format('h:i A') }}
                    @else
                        <em>Not recorded</em>
                    @endif
                </div>

                <div class="info-label"><i class="fas fa-venus-mars"></i> Gender</div>
                <div class="info-value">
                    @if ($baby->gender == 'female')
                        <span class="badge-gender badge-girl">
                            <i class="fas fa-venus me-1"></i> Female
                        </span>
                    @else
                        <span class="badge-gender badge-boy">
                            <i class="fas fa-mars me-1"></i> Male
                        </span>
                    @endif
                </div>

                <div class="info-label"><i class="fas fa-tint"></i> Blood Group</div>
                <div class="info-value">
                    @if ($baby->blood_group)
                        <span class="blood-group">{{ $baby->blood_group }}</span>
                    @else
                        <em>Not recorded</em>
                    @endif
                </div>
            </div>
        </div>


        <!-- Registration Details Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-file-alt me-2"></i>Registration Details
                </h2>
            </div>

            <div class="info-grid">
                <div class="info-label">
                    <i class="fas fa-calendar-check"></i> Registered Date
                </div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($baby->registered_date)->format('F d, Y') }}
                </div>

                <div class="info-label">
                    <i class="fas fa-hashtag"></i> Registration Number
                </div>
                <div class="info-value">{{ $baby->registration_number }}</div>

                <div class="info-label"><i class="fas fa-user-tag"></i> User ID</div>
                <div class="info-value">{{ $baby->user_id }}</div>

                <div class="info-label">
                    <i class="fas fa-hospital"></i> Birth Facility
                </div>
                <div class="info-value">{{ $baby->birth_hospital }}</div>

            </div>
        </div>


        <!-- Birth Measurements Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-ruler-combined me-2"></i>Birth Measurements
                </h2>
            </div>

            <div class="info-grid">
                <div class="info-label">
                    <i class="fas fa-weight"></i> Birth Weight
                </div>
                <div class="info-value">
                    {{ $baby->birth_weight }} kg
                    @if ($baby->birth_weight_lbs && $baby->birth_weight_oz)
                        ({{ $baby->birth_weight_lbs }} lbs {{ $baby->birth_weight_oz }} oz)
                    @endif
                </div>

                <div class="info-label">
                    <i class="fas fa-ruler-vertical"></i> Birth Height
                </div>
                <div class="info-value">
                    {{ $baby->birth_height }} cm
                    @if ($baby->birth_height_inches)
                        ({{ $baby->birth_height_inches }} inches)
                    @endif
                </div>

                <div class="info-label">
                    <i class="fas fa-circle"></i> Head Circumference
                </div>
                <div class="info-value">
                    {{ $baby->head_circumference }} cm
                    @if ($baby->head_circumference_inches)
                        ({{ $baby->head_circumference_inches }} inches)
                    @endif
                </div>

                <div class="info-label">
                    <i class="fas fa-weight"></i> Current Weight
                </div>
                <div class="info-value">
                    {{ $baby->current_weight }} kg
                    @if ($baby->current_weight_lbs && $baby->current_weight_oz)
                        ({{ $baby->current_weight_lbs }} lbs {{ $baby->current_weight_oz }} oz)
                    @endif
                </div>

                <div class="info-label">
                    <i class="fas fa-ruler-vertical"></i> Current Height
                </div>
                <div class="info-value">
                    {{ $baby->current_height }} cm
                    @if ($baby->current_height_inches)
                        ({{ $baby->current_height_inches }} inches)
                    @endif
                </div>
            </div>
        </div>


        <!-- Family Information Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-users me-2"></i>Family Information
                </h2>
            </div>

            <div class="info-grid">
                <div class="info-label">
                    <i class="fas fa-female"></i> Mother's Name
                </div>
                <div class="info-value">{{ $baby->mother_name }}</div>

                <div class="info-label">
                    <i class="fas fa-male"></i> Father's Name
                </div>
                <div class="info-value">{{ $baby->father_name }}</div>

                <div class="info-label"><i class="fas fa-home"></i> Address</div>
                <div class="info-value">
                    {{ $baby->address }}<br />
                    {{ $baby->address_line2 }}<br />
                    {{ $baby->city }}, {{ $baby->postal_code }}<br />
                    {{ $baby->country }}
                </div>

                <div class="info-label">
                    <i class="fas fa-phone"></i> Contact Number
                </div>
                <div class="info-value">{{ $baby->mother_contact }}</div>

                <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                <div class="info-value">{{ $baby->mother_email }}</div>
            </div>
        </div>


        <!-- Health Services Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-medkit me-2"></i>Health Services
                </h2>
            </div>

            <div class="info-grid">
                <div class="info-label">
                    <i class="fas fa-clinic-medical"></i> Regional Health Division
                </div>
                <div class="info-value">
                   Kandy<br />
                    <span class="text-muted small">Kadugannawa</span>
                </div>

                <div class="info-label">
                    <i class="fas fa-id-card"></i> Division ID
                </div>
                <div class="info-value">1403</div>

                <div class="info-label"><i class="fas fa-phone"></i> Contact</div>
                <div class="info-value">
                    <div class="d-flex flex-wrap">
                        <span class="contact-badge">
                            <i class="fas fa-phone-alt me-1"></i> {{ $baby->health_contact_phone }}
                        </span>
                        <span class="contact-badge">
                            <i class="fas fa-fax me-1"></i> {{ $baby->health_contact_fax }}
                        </span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Midwife Information Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user-nurse me-2"></i>Midwife Information
                </h2>

            </div>
            <div class="info-grid">
                <div class="info-label">
                    <i class="fas fa-user-md"></i> Midwife Name
                </div>
                <div class="info-value">Dr. Erandi</div>



                <div class="info-label"><i class="fas fa-phone"></i> Contact</div>
                <div class="info-value">
                    <div class="d-flex flex-wrap">
                        <span class="contact-badge">
                            <i class="fas fa-phone-alt me-1"></i> (555) 456-7890
                        </span>
                        <span class="contact-badge">
                            <i class="fas fa-mobile-alt me-1"></i> (555) 456-7891
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center">
           <a href="{{ route('dashboard') }}" class="btn-back">
    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
</a>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
