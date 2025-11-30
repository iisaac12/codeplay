<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Progress — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
    

    .app-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 12px 0; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
    .app-header-inner { display: flex; align-items: center; justify-content: space-between; }
    
    .brand { text-decoration: none; color: #1e293b; font-weight: 800; font-size: 20px; display: flex; align-items: center; gap: 8px; }
    .app-nav { display: flex; gap: 24px; }
    .nav-link { text-decoration: none; color: #64748b; font-weight: 500; font-size: 14px; transition: color 0.2s; }
    .nav-link:hover, .nav-link.active { color: #1e293b; }
    
    .profile { display: flex; align-items: center; gap: 12px; }
    .profile-info { text-align: right; line-height: 1.2; }
    .profile-info .name { font-weight: 700; font-size: 14px; color: #1e293b; display: block; }
    .profile-info .role { font-size: 11px; color: #64748b; font-weight: 500; }
    .avatar { width: 40px; height: 40px; border-radius: 50%; border: 1px solid #e2e8f0; padding: 2px; }

    
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin: 40px 0; }
    .card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; }
    .stat-card h3 { font-size: 14px; color: #64748b; font-weight: 500; margin-bottom: 8px; }
    .stat-number { font-size: 32px; font-weight: 800; color: #1e293b; }

    
    .charts-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 60px; }
    .chart-card h3 { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 24px; }
    
    
    .pie {
      width: 120px; height: 120px; border-radius: 50%; margin: 0 auto;
      background: conic-gradient(var(--c) calc(var(--p)*1%), #f1f5f9 0);
      position: relative; display: flex; align-items: center; justify-content: center;
    }
    .pie::after {
      content: attr(data-text); 
      position: absolute; background: white; width: 90px; height: 90px;
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 20px; color: #1e293b;
    }
    .mt-8 { margin-top: 16px; text-align: center; font-size: 14px; }

    
    .bars { display: flex; align-items: flex-end; justify-content: space-between; height: 150px; gap: 8px; padding-top: 20px; }
    .bar { 
      flex: 1; background: #eff6ff; border-radius: 6px; position: relative; 
      transition: height 0.5s ease; min-height: 4px;
    }
    .bar-fill {
      background: #3b82f6; width: 100%; border-radius: 6px; position: absolute; bottom: 0;
      transition: height 1s ease;
    }
    
    .bar:hover::after {
      content: attr(data-label) " (" attr(data-value) "%)";
      position: absolute; top: -30px; left: 50%; transform: translateX(-50%);
      background: #1e293b; color: white; padding: 4px 8px; border-radius: 4px;
      font-size: 10px; white-space: nowrap; z-index: 10;
    }

    
    .illu-card { display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; background: #f0fdf4; border-color: #bbf7d0; }
    .illu-icon { font-size: 48px; color: #16a34a; margin-bottom: 16px; }
    
    .text-muted { color: #64748b; }
  </style>
</head>
<body class="bg-light">
  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo" style="width:40px;">
        <span class="brand-name">CodePlay</span>
      </a>
      <nav class="app-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-link">Courses</a>
        <a href="{{ route('materials.index') }}" class="nav-link">Materials</a>
        <a href="{{ route('progress.index') }}" class="nav-link active" style="color: #1e293b;">Progress</a>
        <a href="{{ route('forum.index') }}" class="nav-link">Forum</a>
      </nav>
      <div class="profile">
        <div class="profile-info">
        <div class="profile">
        <a href="{{ route('profile.show') }}" style="text-decoration: none; display: flex; align-items: center; gap: 12px;">
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
    
    <section class="stats-grid">
      <div class="card stat-card">
        <h3>Courses completed</h3>
        <p class="stat-number">{{ $completedCourses }}</p>
      </div>
      <div class="card stat-card">
        <h3>Average quiz score</h3>
        <p class="stat-number">{{ $averageScore }}%</p>
      </div>
      <div class="card stat-card">
        <h3>Current streak</h3>
        <p class="stat-number">{{ $streak }} days</p>
      </div>
    </section>

    <section class="charts-grid">
      

    <div class="card chart-card">
        <h3>Course completion</h3>




        <div class="pie" style="--p:{{ $completionRate }}; --c:#12B76A;" data-text="{{ $completionRate }}%"></div>
        
        <p class="text-muted mt-8">
            {{ $completedCourses }} dari {{ $totalEnrolled }} kursus selesai
        </p>
      </div>

      
      <div class="card chart-card">
        <h3>Recent quiz scores</h3>
        <div class="bars">
          @if($recentAttempts->count() > 0)
              @foreach($recentAttempts as $attempt)
                  @php
                      
                      $percent = $attempt->max_score > 0 ? round(($attempt->score / $attempt->max_score) * 100) : 0;
                      
                      $color = $percent >= 70 ? '#3b82f6' : '#ef4444';
                  @endphp
                  
                  <div class="bar" data-label="{{ Str::limit($attempt->quiz->title, 10) }}" data-value="{{ $percent }}">
                      <div class="bar-fill" style="height: {{ $percent }}%; background: {{ $color }};"></div>
                  </div>
              @endforeach
              
              
              @for($i = 0; $i < (5 - $recentAttempts->count()); $i++)
                  <div class="bar"><div class="bar-fill" style="height: 0%;"></div></div>
              @endfor
          @else
              <p class="text-muted" style="width: 100%; text-align: center; font-size: 12px; margin-top: 40px;">Belum ada data kuis</p>
          @endif
        </div>
      </div>

      
      <div class="card chart-card illu-card">
        <div class="illustration">
          <i class="fa-solid fa-graduation-cap illu-icon"></i>
          <p class="text-muted">Keep going—every step counts.</p>
          <div style="margin-top: 16px; font-weight: 700; color: #166534;">
              {{ Auth::user()->full_name }}
          </div>
        </div>
      </div>

    </section>
  </main>
</body>
</html>