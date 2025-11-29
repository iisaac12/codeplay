<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $course->title }} — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    .detail-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 32px; margin-top: 32px; }
    .hero-thumb { width: 100%; height: 250px; object-fit: cover; border-radius: 8px; }
    @media (max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body class="bg-light">

  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('user.dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo">
        <span class="brand-name">CodePlay</span>
      </a>
      <nav class="app-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-link">Back to Dashboard</a>
      </nav>
    </div>
  </header>

  <main class="container mb-24">
    <div class="detail-grid">
        
        <div class="left-content">
            <h1 class="h1">{{ $course->title }}</h1>
            <p class="lead text-muted">{{ $course->description }}</p>
            
            <div style="display: flex; gap: 10px; margin: 16px 0;">
                <span class="tag">{{ ucfirst($course->level) }}</span>
                <span class="tag success">{{ $course->category->name ?? 'General' }}</span>
                <span class="tag"><i class="fa-solid fa-user"></i> {{ $course->mentor->name ?? 'Mentor' }}</span>
            </div>

            <div class="card mt-16">
                <h3 class="h3">What you will learn</h3>
                <ul style="margin-top: 16px; padding-left: 20px; color: var(--text-muted);">
                    <li>{{ $course->description }}</li>
                </ul>
            </div>
        </div>

        {{-- KOLOM KANAN: KARTU AKSES (TOMBOL ENROLL DISINI) --}}
        <div class="right-sidebar">
            <div class="card card-elevated" style="position: sticky; top: 24px;">
          <img 
              src="{{ $course->thumbnail_url ? asset('storage/' . $course->thumbnail_url) : 'https://placehold.co/600x400?text=No+Image' }}" 
              alt="{{ $course->title }}" 
              class="course-thumb" 
              style="width: 100%; height: 160px; object-fit: cover;"
          />

                {{-- LOGIKA TOMBOL ENROLL --}}
                @auth
                    @if(isset($isEnrolled) && $isEnrolled)
                        {{-- Jika SUDAH Enroll --}}
                        <a href="{{ route('course.learn', $course->slug) }}" class="btn btn-success w-100 btn-lg">
                            Continue Learning
                        </a>
                    @else
                        {{-- Jika BELUM Enroll -> Form POST ke Route Enroll --}}
                        <form action="{{ route('course.enroll', $course->course_id) }}" method="POST">
                            @csrf {{-- Token keamanan wajib --}}
                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                Enroll Now - Free
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-100">Login to Enroll</a>
                @endauth

                <p class="text-muted text-center mt-16" style="font-size: 14px;">
                    <i class="fa-solid fa-lock"></i> Secure enrollment
                </p>
            </div>
        </div>

    </div>
  </main>

</body>
</html>