<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BabyBloom Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Comic+Neue:wght@400;700&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --baby-pink: #ffb6c1;
            --baby-blue: #89cff0;
            --baby-mint: #b5e5cf;
            --baby-lavender: #b4f8c8;
            --baby-peach: #fbe7c6;
            --baby-yellow: #fffacd;
        }

        body {
            background-color: #f1f6f9;
            font-family: "Comic Neue", "Poppins", sans-serif;
        }

        .header {
            background: linear-gradient(135deg, #b6e5d8, var(--baby-blue));
            color: white;
            border-radius: 0 0 25px 25px;
            padding: 20px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .baby-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Improved Notification Bell */
        .notification-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            margin-right: 15px;
        }

        .notification-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .notification-btn i {
            color: var(--baby-pink);
            font-size: 1.2rem;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff6b6b;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Improved Profile Button */
        .profile-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            overflow: hidden;
            padding: 0;
        }

        .profile-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .profile-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-btn i {
            color: var(--baby-blue);
            font-size: 1.3rem;
        }

        /* Remove dropdown caret */
        .dropdown-toggle::after {
            display: none !important;
        }

        /* Notification Dropdown */
        .notification-dropdown {
            position: absolute;
            right: 0;
            top: 50px;
            width: 300px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 15px;
            z-index: 1000;
            display: none;
        }

        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            color: #666;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item i {
            margin-right: 10px;
            color: var(--baby-pink);
        }

        .notification-item.unread {
            background-color: rgba(255, 182, 193, 0.1);
            border-left: 3px solid var(--baby-pink);
            color: #666;
        }

        .notification-item.unread p {

            color: #666;
        }

        .notification-time {
            font-size: 0.7rem;
            color: #999;
            margin-top: 3px;
        }

        /* Rest of your existing styles... */
        .feature-card {
            border-radius: 18px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
            padding: 20px 15px;
            position: relative;
            overflow: hidden;
            background: #b6e5d8;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--baby-pink);
        }

        .parent-info {
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .baby-details {
            background-color: var(--baby-lavender);
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .nav-pills .nav-link {
            border-radius: 15px;
            margin: 0 30px;
            color: #666;
            font-weight: 500;
            padding: 10px 15px;
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--baby-pink), var(--baby-blue));
            color: white;
        }

        .app-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .cute-divider {
            border: none;
            height: 3px;
            background: linear-gradient(90deg, var(--baby-pink), var(--baby-blue));
            border-radius: 3px;
            margin: 20px 0;
            opacity: 0.5;
        }

        .dropdown-menu {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            padding: 8px 15px;
        }

        .dropdown-item:hover {
            background-color: var(--baby-lavender);
        }

        .diary-card {
            background-color: #b4f8c8;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .diary-entry {
            background-color: var(--baby-yellow);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
        }

        .diary-date {
            font-weight: bold;
            color: var(--baby-pink);
            margin-bottom: 5px;
        }

        .diary-content {
            margin-bottom: 10px;
        }

        .add-diary-btn {
            background: linear-gradient(135deg, var(--baby-pink), var(--baby-blue));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: bold;
            margin-top: 10px;
        }

        .diary-textarea {
            border-radius: 12px;
            border: 2px solid var(--baby-lavender);
            padding: 15px;
            width: 100%;
            min-height: 150px;
            resize: vertical;
        }

        .diary-textarea:focus {
            outline: none;
            border-color: var(--baby-pink);
            box-shadow: 0 0 0 3px rgba(255, 182, 193, 0.2);
        }

        .photo-upload-area {
            border: 2px dashed var(--baby-lavender);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 15px 0;
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-upload-area:hover {
            border-color: var(--baby-pink);
            background-color: rgba(255, 182, 193, 0.1);
        }

        .photo-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
        }

        .remove-photo {
            color: #ff6b6b;
            cursor: pointer;
            margin-top: 5px;
            display: none;
        }

        .entry-photo {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .baby-avatar {
                width: 60px;
                height: 60px;
            }

            .feature-icon {
                font-size: 1.5rem;
            }

            .notification-dropdown {
                width: 280px;
                right: 10px;
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
    <div class="app-container">
        <!-- Header Section -->
        <div class="header mb-4">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/1864/1864593.png" alt="Baby"
                            class="baby-avatar me-3" />
                        <div>
                            <h2 class="mb-1 text-white">{{ $baby->name }}</h2>
                            <div class="d-flex align-items-center">
                                <span class="text-white">

                                    <i class="fas fa-birthday-cake me-1"></i>
                                    Born: {{ \Carbon\Carbon::parse($baby->birth_date)->format('F d, Y') }} <br>
                                    {{ round(\Carbon\Carbon::parse($baby->birth_date)->floatDiffInMonths(now()), 1) }}
                                    months old

                                </span>
                            </div>
                        </div>
                    </div>



                    <div class="d-flex align-items-center position-relative">
                        <!-- Notification Button with Dropdown -->
                        <div class="position-relative">
                            <button class="notification-btn" id="notificationBtn">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge">{{ $notifications->count() }}</span>
                            </button>

                            <div class="notification-dropdown" id="notificationDropdown">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 style="color: var(--baby-pink)">Notifications</h6>
                                    @if ($notifications->isNotEmpty())
                                        <form action="{{ route('notifications.clear') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger"
                                                onclick="return confirm('Clear all notifications?')">
                                                Clear All
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                @if ($notifications->isEmpty())
                                    <div class="text-center text-muted">
                                        <i class="fas fa-bell-slash"></i>
                                        <p>No new notifications</p>
                                    </div>
                                @else
                                    @foreach ($notifications as $notification)
                                        <a href="{{ route('baby.checkups') }}?appointment_id={{ $notification->id }}"
                                            class="notification-item {{ $notification->read ? '' : 'unread' }}"
                                            style="text-decoration: none; color: inherit;">
                                            <div class="d-flex align-items-center">
                                                <i
                                                    class="fas fa-{{ $notification->type === 'vaccination' ? 'syringe' : 'calendar-check' }} me-3"></i>
                                                <div>
                                                    <strong>{{ $notification->type === 'vaccination' ? 'Vaccination Appointment' : 'Checkup Appointment' }}</strong>
                                                    <p>
                                                        Scheduled for
                                                        {{ \Carbon\Carbon::parse($notification->date)->format('F d, Y') }}
                                                        {{ $notification->time ? 'at ' . \Carbon\Carbon::parse($notification->time)->format('h:i A') : '' }}
                                                        {{ $notification->type === 'vaccination' && $notification->vaccination_type ? "({$notification->vaccination_type})" : '' }}
                                                    </p>
                                                    <div class="notification-time">
                                                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- Profile Button without dropdown icon -->
                        <div class="dropdown">
                            <button class="profile-btn" type="button" id="profileDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('baby.profile', $baby->id) }}">
                                        <i class="fas fa-user me-2"></i> View Profile
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>

                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rest of your content remains the same... -->
        <div class="container">
            <!-- Navigation -->
            <ul class="nav nav-pills mb-4 justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <a class="nav-link" href="{{ route('vaccination.record') }}">
                    <i class="fas fa-syringe me-1"></i> Vaccination
                </a>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('baby.checkups') }}">
                        <i class="fas fa-heartbeat me-1"></i> Health Checkups
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="diet.html">
                        <i class="fas fa-utensils me-1"></i> Diet & Nutrition
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('baby.diary', ['babyId' => $baby->id]) }}" class="nav-link">
                        <i class="fas fa-book me-1"></i> Baby Diary
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('growth.show', ['baby_id' => $baby->id]) }}">
                        <i class="fas fa-chart-line me-1"></i> Growth
                    </a>
                </li>
            </ul>
            @php
                $vaccines = [
                    $baby->bcg_vaccine,
                    $baby->opv0_vaccine,
                    $baby->hepb_vaccine,
                    $baby->opv1_vaccine,
                    $baby->penta1_vaccine,
                    $baby->ipv_vaccine,
                    $baby->opv2_vaccine,
                    $baby->penta2_vaccine,
                    $baby->opv3_vaccine,
                    $baby->penta3_vaccine,
                    $baby->mmr_vaccine,
                    $baby->je_vaccine,
                    $baby->mmr2_vaccine,
                    // Add or remove fields as per your DB structure
                ];

                $vaccinesCompleted = collect($vaccines)->filter(fn($v) => $v == 1)->count();
                $totalVaccines = count($vaccines);
            @endphp



            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-weight"></i>
                        </div>
                        <h5>{{ $baby->current_weight }} kg</h5>
                        <p class="text-muted small">Current Weight</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-ruler-vertical"></i>
                        </div>
                        <h5>{{ $baby->current_height }} cm</h5>
                        <p class="text-muted small">Current Height</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <h5>{{ $vaccinesCompleted }}/{{ $totalVaccines }}</h5>
                        <p class="text-muted small">Vaccines Completed</p>
                    </div>
                </div>
            </div>


            <div class="cute-divider"></div>

            <!-- Baby Diary Section -->
            <h4 class="mb-4">
                <i class="fas fa-book me-2" style="color: var(--baby-pink)"></i>
                Baby Diary
            </h4>

            <div class="diary-card">
                <!-- Diary Entry Form -->
                <h5>
                    <i class="fas fa-plus-circle me-2" style="color: var(--baby-blue)"></i>New Entry
                </h5>
                <form id="diaryForm">
                    <div class="mb-3">
                        <label class="form-label">Write about your baby's day</label>
                        <textarea class="diary-textarea" placeholder="Record special moments, milestones, or just daily activities..."></textarea>
                    </div>

                    <!-- Photo Upload Section -->
                    <div class="mb-3">
                        <label class="form-label">Add a photo (optional)</label>
                        <div class="photo-upload-area" id="photoUploadArea">
                            <i class="fas fa-camera"
                                style="
                    font-size: 2rem;
                    color: var(--baby-blue);
                    margin-bottom: 10px;
                  "></i>
                            <p>Click to upload or drag & drop a photo</p>
                            <p class="text-muted small">Max file size: 5MB</p>
                            <input type="file" id="photoInput" accept="image/*" style="display: none" />
                            <img id="photoPreview" class="photo-preview" />
                            <div class="remove-photo" id="removePhoto">
                                <i class="fas fa-times me-1"></i>Remove photo
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="add-diary-btn">
                        <i class="fas fa-book-medical me-1"></i> Save Entry
                    </button>
                </form>
            </div>

            <div class="cute-divider"></div>

            <!-- Upcoming Events -->
            <h4 class="mb-4">
                <i class="fas fa-calendar-check me-2" style="color: var(--baby-pink)"></i>
                Upcoming Events
            </h4>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card" style="background-color: var(--baby-mint)">
                        <div class="feature-icon">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <h5>Next Vaccination</h5>
                        <p><strong>MMR Vaccine</strong></p>
                        <p class="mb-2">Due: June 15, 2024</p>
                        <button class="btn btn-sm" style="background-color: white; color: var(--baby-pink)">
                            View Schedule
                        </button>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="feature-card" style="background-color: var(--baby-peach)">
                        <div class="feature-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h5>Next Checkup</h5>
                        <p><strong>12 Month Checkup</strong></p>
                        <p class="mb-2">May 20, 2024</p>
                        <button class="btn btn-sm" style="background-color: white; color: var(--baby-pink)">
                            View Details
                        </button>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="feature-card" style="background-color: var(--baby-lavender)">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h5>Nutrition Plan</h5>
                        <p><strong>New Foods to Try</strong></p>
                        <p class="mb-2">Updated weekly</p>
                        <button class="btn btn-sm" style="background-color: white; color: var(--baby-pink)">
                            View Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Notification dropdown toggle
        const notificationBtn = document.getElementById("notificationBtn");
        const notificationDropdown = document.getElementById(
            "notificationDropdown"
        );

        notificationBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            notificationDropdown.style.display =
                notificationDropdown.style.display === "block" ? "none" : "block";
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", () => {
            notificationDropdown.style.display = "none";
        });

        // Photo upload functionality
        const photoInput = document.getElementById("photoInput");
        const photoPreview = document.getElementById("photoPreview");
        const photoUploadArea = document.getElementById("photoUploadArea");
        const removePhoto = document.getElementById("removePhoto");

        // Click on upload area triggers file input
        photoUploadArea.addEventListener("click", () => {
            photoInput.click();
        });

        // Handle file selection
        photoInput.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert("File is too large! Max size is 5MB.");
                    return;
                }

                const reader = new FileReader();
                reader.onload = (event) => {
                    photoPreview.src = event.target.result;
                    photoPreview.style.display = "block";
                    removePhoto.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });

        // Remove photo
        removePhoto.addEventListener("click", (e) => {
            e.stopPropagation();
            photoPreview.src = "";
            photoPreview.style.display = "none";
            removePhoto.style.display = "none";
            photoInput.value = "";
        });

        // Drag and drop functionality
        photoUploadArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            photoUploadArea.style.borderColor = "var(--baby-pink)";
            photoUploadArea.style.backgroundColor = "rgba(255, 182, 193, 0.2)";
        });

        photoUploadArea.addEventListener("dragleave", () => {
            photoUploadArea.style.borderColor = "var(--baby-lavender)";
            photoUploadArea.style.backgroundColor = "";
        });

        photoUploadArea.addEventListener("drop", (e) => {
            e.preventDefault();
            photoUploadArea.style.borderColor = "var(--baby-lavender)";
            photoUploadArea.style.backgroundColor = "";

            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith("image/")) {
                if (file.size > 5 * 1024 * 1024) {
                    alert("File is too large! Max size is 5MB.");
                    return;
                }

                photoInput.files = e.dataTransfer.files;
                const reader = new FileReader();
                reader.onload = (event) => {
                    photoPreview.src = event.target.result;
                    photoPreview.style.display = "block";
                    removePhoto.style.display = "block";
                };
                reader.readAsDataURL(file);
            }
        });

        // Diary form submission
        document
            .getElementById("diaryForm")
            .addEventListener("submit", function(e) {
                e.preventDefault();
                alert("Diary entry saved successfully!");
                // In a real app, you would save to a database here
                this.reset();
                photoPreview.src = "";
                photoPreview.style.display = "none";
                removePhoto.style.display = "none";
            });
    </script>
</body>

</html>
