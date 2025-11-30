<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Materials — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
      body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
      .app-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 12px 0; }
      .card { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
      
      .materials-list { list-style: none; padding: 0; margin: 24px 0 0 0; }
      .material-item { 
          display: flex; align-items: center; justify-content: space-between; 
          padding: 16px; border: 1px solid #e2e8f0; border-radius: 12px; 
          margin-bottom: 12px; transition: all 0.2s; background: white;
      }
      .material-item:hover { border-color: #cbd5e1; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
      
      .material-info { display: flex; align-items: center; gap: 16px; }
      .material-icon { 
          width: 48px; height: 48px; background: #eff6ff; border-radius: 10px; 
          display: flex; align-items: center; justify-content: center; 
          font-size: 20px; color: #3b82f6; 
      }
      
      .text-muted { color: #64748b; font-size: 14px; margin-top: 4px; }
      .course-badge { 
          display: inline-block; font-size: 11px; font-weight: 600; 
          background: #f1f5f9; color: #475569; padding: 2px 8px; 
          border-radius: 4px; margin-top: 4px; 
      }

      .btn-outline { 
          border: 1px solid #cbd5e1; background: white; color: #475569; 
          padding: 8px 16px; border-radius: 8px; font-weight: 600; 
          text-decoration: none; font-size: 14px; transition: all 0.2s;
          display: inline-flex; align-items: center; justify-content: center;
      }
      .btn-outline:hover { background: #f8fafc; border-color: #94a3b8; color: #1e293b; }
      
      .btn-primary-soft { background: #eff6ff; color: #2563eb; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; text-decoration: none; font-size: 14px; }
      .btn-primary-soft:hover { background: #dbeafe; }
  </style>
</head>
<body class="bg-light">
  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('user.dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo" style="width: 40px;">
        <span class="brand-name">CodePlay</span>
      </a>
      <nav class="app-nav">
        <a href="{{ route('user.dashboard') }}" class="nav-link">Courses</a>
        <a href="{{ route('materials.index') }}" class="nav-link active" style="color: #1e293b;">Materials</a>
        <a href="{{ route('progress.index')}}" class="nav-link">Progress</a>
        <a href="{{ route('forum.index')}}" class="nav-link">Forum</a>
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

  <main class="container" style="max-width: 1000px; margin: 40px auto; padding: 0 24px;">
    
    <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 24px;">
        <div>
            <h1 class="h3" style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Materi Pembelajaran</h1>
            <p class="text-muted">Kumpulan materi dari kursus yang Anda ikuti.</p>
        </div>
    </div>

    @if($materials->count() > 0)
        <ul class="materials-list">
            @foreach($materials as $material)
            <li class="material-item">
                <div class="material-info">
                    
                    <div class="material-icon">
                        @if($material->type == 'video')
                            <i class="fa-solid fa-video"></i>
                        @elseif($material->type == 'pdf')
                            <i class="fa-regular fa-file-pdf"></i>
                        @else
                            <i class="fa-regular fa-file-lines"></i>
                        @endif
                    </div>
                    
                    <div>
                        <a href="{{ route('materials.show', $material->material_id) }}" style="text-decoration: none; color: inherit;">
                            <strong style="font-size: 16px; display: block;">{{ $material->title }}</strong>
                        </a>
                        
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="course-badge">{{ $material->course->title }}</span>
                            <span class="text-muted" style="font-size: 12px;">• {{ ucfirst($material->type) }}</span>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('materials.show', $material->material_id) }}" class="btn-primary-soft">
                        Lihat
                    </a>
                    
                    
                    <a href="{{ route('material.download', $material->material_id) }}" class="btn-outline" title="Download Materi">
                        <i class="fa-solid fa-download"></i>
                    </a>
                </div>
            </li>
            @endforeach
        </ul>

        
        <div style="margin-top: 32px; display: flex; justify-content: center;">
            {{ $materials->links() }}
        </div>

    @else
        
        <div class="card" style="text-align: center; padding: 60px;">
            <div style="background: #f1f5f9; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fa-solid fa-folder-open" style="font-size: 32px; color: #94a3b8;"></i>
            </div>
            <h3 style="color: #475569; margin-bottom: 8px;">Belum ada materi</h3>
            <p class="text-muted">Materi akan muncul di sini setelah Anda mengikuti sebuah kursus.</p>
            <a href="{{ route('user.dashboard') }}" class="btn-primary-soft" style="display: inline-block; margin-top: 16px;">
                Cari Kursus
            </a>
        </div>
    @endif

  </main>

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

        if (errorMessage) {
            Swal.fire({
                title: 'Tidak Bisa Download',
                text: errorMessage,
                icon: 'warning', 
                confirmButtonText: 'Oke',
                confirmButtonColor: '#f59e0b' 
            });
        }

        if (successMessage) {
            Swal.fire({
                title: 'Berhasil',
                text: successMessage,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
  </script>

</body>
</html>