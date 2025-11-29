<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Dashboard — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-light">
  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('user.dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo">
        <span class="brand-name">CodePlay</span>
      </a>
      <nav class="app-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-link active">Courses</a>
        <a href="{{ route('materials.index') }}" class="nav-link">Materials</a>
        <a href="{{ route('progress.index')}}" class="nav-link">Progress</a>
        <a href="{{ route('forum.index')}}" class="nav-link">Forum</a>
      </nav>
      
      <!-- PROFILE SECTION (UPDATED) -->
      <div class="profile">
        <a href="{{ route('profile.show') }}" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
            <!-- Avatar Logic: Cek DB -> Fallback UI Avatars -->
            <img 
                src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($user->full_name ?? $user->username).'&background=3b82f6&color=fff&bold=true' }}" 
                alt="Profile" 
                class="avatar" 
                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0; padding: 1px;"
            />
            <div class="profile-info" style="text-align: right; line-height: 1.2;">
                <span class="name" style="font-weight: 700; font-size: 14px; color: #1e293b; display: block;">
                    {{ $user->full_name ?? $user->username }}
                </span>
                <span class="role text-muted" style="font-size: 11px; font-weight: 500;">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </a>
      </div>

    </div>
  </header>

  <main class="container">
    <section class="welcome card">
      <div>
        <h1 class="h3">Welcome back, {{ $user->full_name ?? $user->username }}</h1>
        <p class="text-muted">Continue where you left off or explore new courses.</p>
      </div>
    </section>

    <!-- Filter Form -->
    <form action="{{ route('user.dashboard') }}" method="GET" class="filter-bar card">
      <div class="filter-group">
        <label for="search">Search</label>
        <input type="text" name="search" id="search" class="select" placeholder="Search courses..." value="{{ request('search') }}">
      </div>

      <div class="filter-group">
        <label for="category">Category</label>
        <select name="category" id="category" class="select" onchange="this.form.submit()">
          <option value="">All Categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="filter-group">
        <label for="level">Level</label>
        <select name="level" id="level" class="select" onchange="this.form.submit()">
          <option value="">All Levels</option>
          <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
          <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
          <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
        </select>
      </div>

      <div class="filter-group">
          <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary" style="padding: 10px; text-decoration:none; border:1px solid #ccc; border-radius:8px;">Reset</a>
      </div>
    </form>

    {{-- GRID COURSES --}}
    <section class="courses-grid">
      @forelse($courses as $course)
        <article class="course-card card card-elevated">
          
          {{-- GAMBAR KURSUS (DIPERBAIKI) --}}
          {{-- Kita tambahkan onerror agar kalau gambar rusak, otomatis ganti placeholder --}}
          <img 
              src="{{ $course->thumbnail_url ? asset('storage/' . $course->thumbnail_url) : 'https://placehold.co/600x400?text=No+Image' }}" 
              alt="{{ $course->title }}" 
              class="course-thumb" 
              style="width: 100%; height: 160px; object-fit: cover;"
          />
          
          <div class="course-content">
            <div class="course-top">
              <h3>{{ $course->title }}</h3>
              <span class="level tag">{{ ucfirst($course->level) }}</span>
            </div>
            
            <p class="text-muted">{{ Str::limit($course->description, 80) }}</p>
            
            @php
                $userEnrollment = isset($enrollments) ? ($enrollments[$course->course_id] ?? null) : null;
            @endphp

            @if($userEnrollment)
                <div class="progress-wrap">
                    @php $percent = $userEnrollment->progress_percentage; @endphp
                    
                    <div class="progress-bar">
                        <span class="progress" style="width: {{ $percent }}%"></span>
                    </div>
                    
                    <span class="progress-label" style="display: flex; justify-content: space-between; width: 100%;">
                        <span>{{ $percent == 100 ? 'Completed 🎉' : 'In Progress' }}</span>
                        <strong>{{ round($percent) }}%</strong>
                    </span>
                </div>
                
                <div class="card-actions">
                    <a href="{{ route('course.learn', $course->slug) }}" class="btn {{ $percent == 100 ? 'btn-success' : 'btn-primary' }}">
                        {{ $percent == 100 ? 'Review Course' : 'Continue Learning' }}
                    </a>
                </div>
            @else
                <div class="progress-wrap" style="opacity: 0; visibility: hidden;">
                    <div class="progress-bar"></div> 
                </div>
                <div class="card-actions">
                    <a href="{{ route('course.show', $course->slug) }}" class="btn btn-outline-primary w-100">View Details</a>
                </div>
            @endif

          </div>
        </article>
      @empty
        <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 40px;">
            <i class="fa-solid fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 16px;"></i>
            <h3>No courses found</h3>
            <p class="text-muted">Try adjusting your filters or search keywords.</p>
        </div>
      @endforelse
    </section>

    <div style="margin-top: 32px; display: flex; justify-content: center;">
        {{ $courses->withQueryString()->links() }}
    </div>

  </main>

  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>