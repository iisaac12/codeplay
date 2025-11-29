<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $material->title }} — {{ $course->title }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <!-- 1. Kita tambahkan CSS SweetAlert -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    /* Style sama persis dengan learn.blade.php */
    .learn-grid { display: grid; grid-template-columns: 350px 1fr; gap: 24px; margin-top: 24px; align-items: start; }
    .curriculum-card { max-height: calc(100vh - 100px); overflow-y: auto; position: sticky; top: 24px; }
    .lesson-item { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 8px; text-decoration: none; color: var(--text); border: 1px solid transparent; margin-bottom: 4px; }
    .lesson-item:hover { background-color: #F9FAFB; }
    .lesson-icon { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: #EEF2F6; border-radius: 6px; color: var(--text-muted); font-size: 14px; }
    
    /* Highlight materi yang sedang dibuka */
    .lesson-item.active { background-color: #EFF6FF; border-color: #0056D2; }
    .lesson-item.active .lesson-icon { background-color: #0056D2; color: white; }

    .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; background: #000; }
    .video-wrapper iframe, .video-wrapper video { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    
    @media (max-width: 900px) { .learn-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body class="bg-light">

  {{-- HEADER --}}
  <header class="app-header">
    <div class="container app-header-inner">
      <a href="{{ route('user.dashboard') }}" class="brand">
        <img src="{{ asset('assets/logo.svg') }}" class="logo">
        <span class="brand-name">CodePlay</span>
      </a>
      <div class="nav">
        {{-- Tombol kembali ke halaman depan course --}}
        <a href="{{ route('course.show', $course->slug) }}" class="btn btn-ghost btn-sm">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Course Home
        </a>
      </div>
    </div>
  </header>

  <main class="container mb-24">
    <div class="learn-grid">

        {{-- SIDEBAR: DAFTAR ISI (CURRICULUM) --}}
        <aside class="curriculum-card card card-elevated">
            <h3 class="h3 mb-16">Curriculum</h3>
            
            {{-- Loop Materi --}}
            <div class="module-title"><i class="fa-solid fa-book me-2"></i> Materials</div>
            @foreach($course->materials as $item)
                <a href="{{ route('materials.show', $item->material_id) }}" 
                   class="lesson-item {{ $item->material_id == $material->material_id ? 'active' : '' }}">
                    <div class="lesson-icon">
                        @if($item->type == 'video') <i class="fa-solid fa-play"></i>
                        @elseif($item->type == 'pdf') <i class="fa-regular fa-file-pdf"></i>
                        @else <i class="fa-regular fa-file-lines"></i> @endif
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 14px; font-weight: 500;">{{ $item->title }}</div>
                        <small class="text-muted">{{ $item->duration ? $item->duration . ' min' : 'Read' }}</small>
                    </div>
                    
                    {{-- Indikator Centang Jika Selesai (Opsional, perlu cek progress) --}}
                    @if($item->material_id == $material->material_id)
                        <i class="fa-solid fa-circle-play text-primary"></i>
                    @endif
                </a>
            @endforeach
            
        </aside>

        {{-- AREA KONTEN UTAMA --}}
        <section class="content-area">
            <div class="card card-elevated p-0 overflow-hidden">
                
                {{-- LOGIKA TAMPILAN KONTEN BERDASARKAN TIPE --}}
                
                {{-- 1. JIKA VIDEO --}}
                @if($material->type == 'video')
                    <div class="video-wrapper">
                        {{-- Cek apakah file lokal atau link youtube --}}
                        @if(Str::contains($material->file_url, ['youtube.com', 'youtu.be']))
                            <iframe src="{{ $material->file_url }}" allowfullscreen></iframe>
                        @else
                            {{-- Video Lokal (Storage) --}}
                            <video controls>
                                <source src="{{ asset('storage/' . $material->file_url) }}" type="video/mp4">
                                Browser Anda tidak mendukung video.
                            </video>
                        @endif
                    </div>
                

                @elseif($material->type == 'pdf')
                    <div style="height: 600px; overflow: hidden;">
                        <iframe src="{{ route('material.stream', $material->material_id) }}" 
                                style="width: 100%; height: 100%; border: none;">
                        </iframe>
                    </div>

                    @else
                    <div class="p-5">
                        {{-- Menampilkan Gambar Cover jika ada --}}
                        @if($material->file_url && !Str::endsWith($material->file_url, '.pdf'))
                            <img src="{{ asset('storage/' . $material->file_url) }}" class="w-100 rounded mb-4">
                        @endif
                        
                        <div class="typography" style="line-height: 1.8; color: #374151;">
                            {!! $material->content !!} {{-- Render HTML dari database --}}
                        </div>
                    </div>
                @endif

                {{-- BAGIAN BAWAH KONTEN (JUDUL & NAVIGASI) --}}
                <div class="p-4 border-top">
                    <h1 class="h2">{{ $material->title }}</h1>
                    <p class="text-muted">{{ $material->description ?? 'Pelajari materi ini dengan seksama.' }}</p>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-outline" disabled>Previous Lesson</button>
                        
                        <!-- FORM MARK AS COMPLETED -->
                        <form action="{{ route('material.progress', $material->material_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="completed" value="1">
                            <div style="height: 10px;"></div>
                            
                            <button type="submit" class="btn btn-primary">
                                Mark as Completed <i class="fa-solid fa-check ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </section>

    </div>
  </main>

  <!-- 2. Tambahkan JS SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- 3. Script untuk menangkap Session Success dari Controller -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = {!! json_encode(session('success')) !!};
        const errorMessage = {!! json_encode(session('error')) !!};

        if (successMessage) {
            Swal.fire({
                title: 'Good Job! 🎉',
                text: successMessage, // Pesan dari controller
                icon: 'success',
                confirmButtonText: 'Lanjut',
                confirmButtonColor: '#3b82f6', // Sesuaikan warna primary kamu
                timer: 3000, // Otomatis tutup dalam 3 detik (opsional)
                timerProgressBar: true
            });
        }
        
        if (errorMessage) {
            Swal.fire({
                title: 'Oops...',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Tutup'
            });
        }
    });
  </script>

</body>
</html>