<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $thread->title }} — CodePlay Forum</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
    
    /* Header Styles */
    .app-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 12px 0; }
    .container { max-width: 1000px; margin: 0 auto; padding: 0 24px; }
    .app-header-inner { display: flex; align-items: center; justify-content: space-between; }
    .brand { text-decoration: none; color: #1e293b; font-weight: 800; font-size: 20px; display: flex; align-items: center; gap: 8px; }
    .app-nav { display: flex; gap: 24px; }
    .nav-link { text-decoration: none; color: #64748b; font-weight: 500; font-size: 14px; transition: color 0.2s; }
    .nav-link:hover, .nav-link.active { color: #1e293b; }

    /* Thread Styles */
    .thread-card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 32px; margin-top: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); }
    .thread-header { margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #f1f5f9; }
    .thread-title { font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 12px; line-height: 1.4; }
    
    .user-meta { display: flex; align-items: center; gap: 12px; }
    .avatar { width: 40px; height: 40px; border-radius: 50%; border: 1px solid #e2e8f0; }
    .user-info { line-height: 1.3; }
    .user-name { font-weight: 700; font-size: 14px; color: #1e293b; display: block; }
    .post-date { font-size: 12px; color: #64748b; }

    .thread-content { font-size: 16px; line-height: 1.8; color: #334155; white-space: pre-wrap; }
    
    .tags-wrapper { margin-top: 24px; display: flex; gap: 8px; }
    .category-tag { background: #eff6ff; color: #3b82f6; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; }

    /* Replies Styles */
    .replies-section { margin-top: 40px; margin-bottom: 60px; }
    .section-label { font-size: 14px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px; }
    
    .reply-card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
    .reply-card.solution { border: 2px solid #22c55e; background: #f0fdf4; }
    .solution-badge { background: #22c55e; color: white; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; margin-left: 8px; }

    /* Reply Form */
    .reply-form { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-top: 40px; }
    .form-textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 16px; font-family: inherit; font-size: 14px; min-height: 120px; margin-bottom: 16px; resize: vertical; outline: none; }
    .form-textarea:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    
    .btn-primary { background: #3b82f6; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
    .btn-primary:hover { background: #2563eb; }
    
    .back-link { display: inline-flex; align-items: center; gap: 8px; color: #64748b; text-decoration: none; font-size: 14px; font-weight: 500; margin-top: 24px; transition: color 0.2s; }
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
    
    <!-- Breadcrumb / Back -->
    <a href="{{ route('forum.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Forum
    </a>

    <!-- 1. THREAD UTAMA (PERTANYAAN) -->
    <article class="thread-card">
        <div class="thread-header">
            <!-- Tags -->
            @if($thread->course)
                <div style="margin-bottom: 12px;">
                    <span class="category-tag">{{ $thread->course->category->name ?? 'General' }}</span>
                </div>
            @endif

            <h1 class="thread-title">{{ $thread->title }}</h1>
            
            <!-- User Meta -->
            <div class="user-meta">
<img 
                src="{{ $user->avatar_url ? asset('storage/' . $user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($user->full_name ?? $user->username).'&background=3b82f6&color=fff&bold=true' }}" 
                alt="Profile" 
                class="avatar" 
                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #e2e8f0; padding: 1px;"
            />
                            <div class="user-info">
                    <span class="user-name">{{ $thread->user->full_name }}</span>
                    <span class="post-date">Diposting {{ $thread->created_at->diffForHumans() }} · <i class="fa-regular fa-eye"></i> {{ $thread->view_count }} dilihat</span>
                </div>
            </div>
        </div>

        <div class="thread-content">
            {!! nl2br(e($thread->content)) !!}
        </div>
    </article>

    <!-- 2. DAFTAR BALASAN (REPLIES) -->
    <section class="replies-section">
        <div class="section-label">{{ $thread->replies_count }} Balasan</div>

        @forelse($thread->replies as $reply)
            <div class="reply-card {{ $reply->is_solution ? 'solution' : '' }}">
                <div class="user-meta" style="margin-bottom: 16px;">
                    <img src="{{ $reply->user->avatar_url ? asset($reply->user->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($reply->user->full_name).'&background=random' }}" class="avatar" style="width: 32px; height: 32px;">
                    <div class="user-info">
                        <div style="display: flex; align-items: center;">
                            <span class="user-name">{{ $reply->user->full_name }}</span>
                            @if($reply->is_solution)
                                <span class="solution-badge"><i class="fa-solid fa-check"></i> Solusi Terbaik</span>
                            @endif
                        </div>
                        <span class="post-date">{{ $reply->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="thread-content" style="font-size: 15px;">
                    {!! nl2br(e($reply->content)) !!}
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px; background: white; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <p style="color: #94a3b8;">Belum ada balasan. Jadilah yang pertama menjawab!</p>
            </div>
        @endforelse
    </section>

    <!-- 3. FORM BALASAN -->
    @auth
    <section class="reply-form" id="reply-form">
        <h3 class="h5" style="margin-top: 0; margin-bottom: 16px; font-weight: 700; color: #1e293b;">Tulis Balasan</h3>
        
        <form action="{{ route('forum.reply', $thread->thread_id) }}" method="POST">
            @csrf
            <textarea name="content" class="form-textarea" placeholder="Tulis jawaban atau tanggapan Anda di sini..." required></textarea>
            
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Balasan
                </button>
            </div>
        </form>
    </section>
    @endauth

  </main>

  <!-- SweetAlert & Flash Data -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <div id="flash-data" 
       data-success="{{ session('success') }}" 
       data-error="{{ session('error') }}"
       style="display: none;">
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashData = document.getElementById('flash-data');
        const successMessage = flashData.getAttribute('data-success');
        const errorMessage = flashData.getAttribute('data-error');

        if (successMessage) {
            Swal.fire({
                title: 'Berhasil!',
                text: successMessage,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
        
        if (errorMessage) {
            Swal.fire({
                title: 'Gagal',
                text: errorMessage,
                icon: 'error'
            });
        }
    });
  </script>

</body>
</html>