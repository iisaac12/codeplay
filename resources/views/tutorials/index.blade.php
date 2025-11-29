<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar Tutorial — CodePlay</title> @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
    .card-tutorial { 
        background: white; border: 1px solid #e2e8f0; border-radius: 12px; 
        padding: 24px; transition: all 0.2s; position: relative; overflow: hidden;
        display: flex; flex-direction: column;
    }
    .card-tutorial:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-color: #cbd5e1; }
    .badge { padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .badge-blue { background: #dbeafe; color: #1e40af; }
    .icon-box { 
        width: 48px; height: 48px; border-radius: 10px; background: #eff6ff; 
        display: flex; align-items: center; justify-content: center; 
        font-size: 24px; color: #3b82f6; margin-bottom: 16px;
    }
  </style>
</head>
<body>

  <header class="app-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 12px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 0 24px;">
      <a href="{{ route('user.dashboard') }}" class="brand" style="text-decoration: none; color: #1e293b; font-weight: 800; font-size: 20px; display: flex; align-items: center; gap: 8px;">
        <img src="{{ asset('assets/logo.svg') }}" class="logo">
        <span class="brand-name">CodePlay</span>
      </a>
      
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

  <main style="max-width: 1200px; margin: 40px auto; padding: 0 24px;">
    
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Pilih Tutorial Coding</h1>
        <p style="color: #64748b; font-size: 16px;">Asah kemampuan kodingmu dengan latihan interaktif langsung di browser.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
        
        @forelse($tutorials as $tutorial)
            <div class="card-tutorial">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div class="icon-box">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <span class="badge badge-blue">{{ $tutorial->course->title ?? 'Umum' }}</span>
                </div>

                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">
                    <a href="{{ route('tutorial.show', $tutorial->tutorial_id) }}" style="text-decoration: none; color: inherit;">
                        {{ $tutorial->title }}
                    </a>
                </h3>
                
                <p style="color: #64748b; font-size: 14px; line-height: 1.5; margin-bottom: 20px; flex-grow: 1;">
                    {{ Str::limit($tutorial->description ?? 'Belajar coding interaktif.', 80) }}
                </p>

                <a href="{{ route('tutorial.show', $tutorial->tutorial_id) }}" class="btn btn-primary" style="display: block; text-align: center; background: #3b82f6; color: white; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Mulai Belajar <i class="fa-solid fa-arrow-right" style="font-size: 12px; margin-left: 4px;"></i>
                </a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: white; border-radius: 16px; border: 1px dashed #cbd5e1;">
                <div style="font-size: 48px; margin-bottom: 16px;">📭</div>
                <h3 style="color: #475569; font-weight: 700; margin-bottom: 8px;">Belum ada tutorial tersedia</h3>
                <p style="color: #94a3b8;">Silakan tunggu update materi selanjutnya dari mentor.</p>
            </div>
        @endforelse

    </div>

  </main>
</body>
</html>