<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Baby Diary | BabyCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
            --baby-yellow: #fffacd;
            --header-gradient: linear-gradient(135deg, var(--baby-pink), var(--baby-blue));
        }

        body {
            background-color: #fff9f9;
            font-family: "Comic Neue", "Poppins", sans-serif;
        }

        .diary-header {
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
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .diary-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .entry-card {
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            border-left: 4px solid var(--baby-pink);
        }

        .entry-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .entry-date {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 5px;
        }

        .entry-photo {
            width: 100%;
            border-radius: 5px;
            margin: 10px 0;
            max-height: 200px;
            object-fit: cover;
        }

        .photo-container {
            display: none;
        }

        .photo-container.show {
            display: block;
        }

        .btn-toggle-photo {
            background: var(--baby-pink);
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-toggle-photo:hover {
            background: #ff99aa;
            transform: translateY(-1px);
        }

        .milestone-badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 0.8rem;
            border-radius: 5px;
            font-weight: 500;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 182, 193, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--baby-pink);
            font-size: 1.2rem;
        }

        .btn-diary {
            background: var(--header-gradient);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-diary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        .mood-selector .btn-check:checked+.btn {
            background-color: var(--baby-blue);
            color: white;
        }

        .memory-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .memory-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .memory-card .card-body {
            flex-grow: 1;
        }

        .btn-view-all {
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-view-all:hover {
            background: var(--baby-blue);
            color: white;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .activity-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }

            .memory-img {
                height: 150px;
            }

            .btn-view-all {
                padding: 5px 10px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>
    <script>
  // Auto close alerts after 6 seconds
  setTimeout(function () {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
      // Bootstrap 5 fade out
      alert.classList.remove('show');
      alert.classList.add('fade');
      setTimeout(() => alert.remove(), 300); // Remove from DOM after fade
    });
  }, 2000);
</script>
    @if ($baby)
        <div class="diary-header">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Dashboard
                        </a>
                        <img src="https://cdn-icons-png.flaticon.com/512/1864/1864593.png" alt="avatar"
                            class="baby-avatar" />
                        <div>
                            <h2 class="mb-1 text-white">{{ $baby->name }}</h2>
                            <div class="d-flex align-items-center">
                                <span class="text-white"><i class="fas fa-book"></i> Baby Diary</span>
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

        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="diary-card">
                <ul class="nav nav-tabs" id="diaryTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') == 'entries' ? 'active' : '' }}" id="entries-tab"
                            data-bs-toggle="tab" data-bs-target="#entries" type="button" role="tab">
                            <i class="fas fa-book-open"></i> Entries
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ request('tab') != 'entries' ? 'active' : '' }}" id="new-tab"
                            data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab">
                            <i class="fas fa-plus"></i> New Entry
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="memories-tab" data-bs-toggle="tab" data-bs-target="#memories"
                            type="button" role="tab">
                            <i class="fas fa-images"></i> Memories
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="diaryTabContent">
                    <div class="tab-pane fade {{ request('tab') == 'entries' ? 'show active' : '' }}" id="entries"
                        role="tabpanel">
                        <form id="search-form" action="{{ route('baby.diary', $baby->id) }}" method="GET">
                            <input type="hidden" name="tab" value="entries" />
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" class="form-control" name="search_date" id="search-date"
                                            value="{{ request('search_date', now()->format('Y-m-d')) }}"
                                            onchange="if(this.value) this.form.submit();" />
                                        <a href="{{ route('baby.diary', ['babyId' => $baby->id, 'tab' => 'entries']) }}"
                                            class="btn btn-outline-secondary btn-view-all ms-2">
                                            <i class="fas fa-list"></i> View All
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- <p>Debug: {{ $entries->count() }} entries found on this page.</p> --}}
                        @forelse ($entries as $entry)
                            <div class="entry-card">
                                <div class="entry-date">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ \Carbon\Carbon::parse($entry->entry_date)->format('F d, Y') }} •
                                    {{ \Carbon\Carbon::parse($entry->entry_time)->format('h:i A') }}
                                </div>
                                <h5>
                                    {{ $entry->title }}
                                    @if ($entry->mood)
                                        <span class="milestone-badge"
                                            style="background: rgba(255,182,193,0.2); color: #a94442">
                                            <i
                                                class="fas fa-{{ $entry->mood == 'happy' ? 'laugh-beam' : ($entry->mood == 'sleepy' ? 'bed' : ($entry->mood == 'fussy' ? 'tired' : 'thermometer')) }}"></i>
                                            {{ ucfirst($entry->mood) }}
                                        </span>
                                    @endif
                                </h5>
                                <p>{{ $entry->description }}</p>
                                @if ($entry->photo_path)
                                    <button type="button" class="btn-toggle-photo mb-2"
                                        onclick="togglePhoto('photo-container-{{ $entry->id }}')">
                                        <i class="fas fa-image"></i> Show Photo
                                    </button>
                                    <div id="photo-container-{{ $entry->id }}" class="photo-container">
                                        <img src="{{ Storage::url($entry->photo_path) }}" alt="{{ $entry->title }}"
                                            class="entry-photo" />
                                    </div>
                                @endif
                                <div class="d-flex align-items-center mt-2">
                                    <div class="activity-icon">
                                        <i
                                            class="fas fa-{{ $entry->mood == 'happy' ? 'laugh-beam' : ($entry->mood == 'sleepy' ? 'bed' : ($entry->mood == 'fussy' ? 'tired' : ($entry->mood == 'sick' ? 'thermometer' : 'book'))) }}"></i>
                                    </div>
                                    <div class="ms-3">
                                        <strong>Diary Entry</strong>
                                        <div class="text-muted">Recorded on
                                            {{ \Carbon\Carbon::parse($entry->created_at)->format('F d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No entries found for the selected date.</p>
                        @endforelse
                        {{ $entries->appends(array_filter(['search_date' => request('search_date'), 'tab' => 'entries']))->links() }}
                    </div>

                    <div class="tab-pane fade {{ request('tab') != 'entries' ? 'show active' : '' }}" id="new"
                        role="tabpanel">
                        <form action="{{ route('baby.diary.store', $baby->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Date & Time</label>
                                <div class="input-group">
                                    <input type="date"
                                        class="form-control @error('entry_date') is-invalid @enderror"
                                        name="entry_date" value="{{ old('entry_date', now()->format('Y-m-d')) }}"
                                        required />
                                    @error('entry_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="time"
                                        class="form-control @error('entry_time') is-invalid @enderror"
                                        name="entry_time" value="{{ old('entry_time', now()->format('H:i')) }}"
                                        required />
                                    @error('entry_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title') }}"
                                    placeholder="E.g.: First tooth appeared!" required />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Entry</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5"
                                    placeholder="Record your special moments..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Mood</label>
                                <div class="btn-group mood-selector w-100" role="group">
                                    <input type="radio" class="btn-check" name="mood" id="mood-happy"
                                        value="happy" autocomplete="off"
                                        {{ old('mood') == 'happy' ? 'checked' : '' }} />
                                    <label class="btn btn-outline-secondary" for="mood-happy"><i
                                            class="fas fa-laugh-beam"></i> Happy</label>
                                    <input type="radio" class="btn-check" name="mood" id="mood-sleepy"
                                        value="sleepy" autocomplete="off"
                                        {{ old('mood') == 'sleepy' ? 'checked' : '' }} />
                                    <label class="btn btn-outline-secondary" for="mood-sleepy"><i
                                            class="fas fa-bed"></i> Sleepy</label>
                                    <input type="radio" class="btn-check" name="mood" id="mood-fussy"
                                        value="fussy" autocomplete="off"
                                        {{ old('mood') == 'fussy' ? 'checked' : '' }} />
                                    <label class="btn btn-outline-secondary" for="mood-fussy"><i
                                            class="fas fa-tired"></i> Fussy</label>
                                    <input type="radio" class="btn-check" name="mood" id="mood-sick"
                                        value="sick" autocomplete="off"
                                        {{ old('mood') == 'sick' ? 'checked' : '' }} />
                                    <label class="btn btn-outline-secondary" for="mood-sick"><i
                                            class="fas fa-thermometer"></i> Sick</label>
                                </div>
                                @error('mood')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Add Photo</label>
                                <div class="border rounded p-4 text-center">
                                    <i class="fas fa-camera fa-3x mb-2" style="color: #ddd;"></i>
                                    <p class="text-muted">Click to upload or drag & drop</p>
                                    <input class="form-control @error('photo') is-invalid @enderror" type="file"
                                        name="photo" id="photo-upload" accept="image/*" />
                                    @error('photo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn-diary">
                                    <i class="fas fa-save"></i> Save Entry
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="memories" role="tabpanel">
                        <div class="row">
                            @forelse ($entries->whereNotNull('photo_path') as $photo)
                                <div class="col-md-4 mb-4">
                                    <div class="card border-0 memory-card">
                                        <img src="{{ Storage::url($photo->photo_path) }}" class="memory-img"
                                            alt="{{ $photo->title }}" />
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $photo->title }}</h6>
                                            <p class="text-muted">
                                                {{ \Carbon\Carbon::parse($photo->entry_date)->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>No photos found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="alert alert-primary">
                <p>No entries created yet.</p>
                {{-- <a href="{{ route('baby.create') }}" class="btn btn-primary">Create baby profile</a> --}}
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePhoto(id) {
            const container = document.getElementById(id);
            const button = document.querySelector(`button[onclick="togglePhoto('${id}')"]`);
            if (container.classList.contains('show')) {
                container.classList.remove('show');
                button.innerHTML = '<i class="fas fa-image"></i> Show Photo';
            } else {
                container.classList.add('show');
                button.innerHTML = '<i class="fas fa-image"></i> Hide Photo';
            }
        }
    </script>
</body>

</html>
