<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Buat Pertanyaan — CodePlay Forum</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
    
    /* Header Styles (Konsisten) */
    .app-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 12px 0; }
    .container { max-width: 800px; margin: 0 auto; padding: 0 24px; }
    .app-header-inner { display: flex; align-items: center; justify-content: space-between; }
    .brand { text-decoration: none; color: #1e293b; font-weight: 800; font-size: 20px; display: flex; align-items: center; gap: 8px; }
    .app-nav { display: flex; gap: 24px; }
    .nav-link { text-decoration: none; color: #64748b; font-weight: 500; font-size: 14px; transition: color 0.2s; }
    .nav-link:hover, .nav-link.active { color: #1e293b; }

    /* Form Styles */
    .form-card { 
        background: white; border: 1px solid #e2e8f0; border-radius: 16px; 
        padding: 40px; margin-top: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); 
    }
    
    .form-title { font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
    .form-desc { color: #64748b; font-size: 14px; margin-bottom: 32px; }

    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-weight: 600; color: #334155; margin-bottom: 8px; font-size: 14px; }
    
    .form-input, .form-select, .form-textarea { 
        width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; 
        border-radius: 8px; font-family: inherit; font-size: 14px; 
        transition: border-color 0.2s, box-shadow 0.2s; outline: none;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus { 
        border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); 
    }
    
    .form-textarea { min-height: 200px; resize: vertical; line-height: 1.6; }
    
    .btn-primary { 
        background: #3b82f6; color: white; border: none; padding: 12px 24px; 
        border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; 
        font-size: 14px; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-primary:hover { background: #2563eb; }
    
    .btn-ghost { 
        background: transparent; color: #64748b; border: none; padding: 12px 24px; 
        font-weight: 600; cursor: pointer; font-size: 14px; text-decoration: none; 
    }
    .btn-ghost:hover { color: #1e293b; }

    .back-link { display: inline-flex; align-items: center; gap: 8px; color: #64748b; text-decoration: none; font-size: 14px; font-weight: 500; margin-top: 32px; transition: color 0.2s; }
    .back-link:hover { color: #1e293b; }
  </style>
</head>
<body class="bg-light">

  {{-- HEADER --}}
  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('user.dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo" style="width:40px;">
        <span class="brand-name">CodePlay</span>
      </a>
      <nav class="app-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-link">Courses</a>
        <a href="{{ route('materials.index') }}" class="nav-link">Materials</a>
        <a href="{{ route('progress.index')}}" class="nav-link">Progress</a>
        <a href="{{ route('forum.index')}}" class="nav-link active" style="color: #1e293b;">Forum</a>
      </nav>
      
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
    
    <a href="{{ route('forum.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Forum
    </a>

    <div class="form-card">
        <h1 class="form-title">Buat Pertanyaan Baru</h1>
        <p class="form-desc">Punya kesulitan koding? Tanyakan pada komunitas dan mentor kami.</p>

        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            
            {{-- JUDUL --}}
            <div class="form-group">
                <label for="title" class="form-label">Judul Pertanyaan</label>
                <input type="text" name="title" id="title" class="form-input" 
                       placeholder="Contoh: Bagaimana cara menggunakan Flexbox di CSS?" 
                       value="{{ old('title') }}" required autofocus>
                @error('title')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- TOPIK / KURSUS --}}
            <div class="form-group">
                <label for="course_id" class="form-label">Topik Terkait (Opsional)</label>
                <select name="course_id" id="course_id" class="form-select">
                    <option value="">-- Pilih Topik / Kursus --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->course_id }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
                <p style="font-size: 12px; color: #94a3b8; margin-top: 6px;">Memilih topik membantu mentor menemukan pertanyaan Anda lebih cepat.</p>
            </div>

            {{-- ISI KONTEN --}}
            <div class="form-group">
                <label for="content" class="form-label">Detail Pertanyaan</label>
                <textarea name="content" id="content" class="form-textarea" 
                          placeholder="Jelaskan masalah Anda secara rinci. Anda bisa menyertakan potongan kode di sini..." required>{{ old('content') }}</textarea>
                @error('content')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- BUTTONS --}}
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 32px; border-top: 1px solid #f1f5f9; padding-top: 24px;">
                <a href="{{ route('forum.index') }}" class="btn-ghost">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-paper-plane"></i> Posting Pertanyaan
                </button>
            </div>

        </form>
    </div>

  </main>

</body>
</html>