<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $step->title }} — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    .card-box { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .editor-dark { background-color: #0f172a; color: #22c55e; border: none; font-family: 'Fira Code', monospace; width: 100%; height: 250px; padding: 16px; border-radius: 0 0 8px 8px; resize: vertical; outline: none; }
    .instruction-box { background-color: #eff6ff; border-radius: 8px; padding: 20px; color: #334155; line-height: 1.6; font-size: 15px; margin-top: 16px; margin-bottom: 24px; }
    .btn-nav { padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-prev { background: white; border: 1px solid #cbd5e1; color: #64748b; }
    .btn-prev:hover { border-color: #94a3b8; color: #475569; }
    .btn-next { background: #3b82f6; border: 1px solid #3b82f6; color: white; }
    .btn-next:hover { background: #2563eb; }
    .btn-run { background: #22c55e; color: white; padding: 6px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; display: flex; align-items: center; gap: 6px; }
    .btn-run:hover { background: #16a34a; }
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 100; opacity: 0; transition: opacity 0.3s; }
    .modal-overlay.open { display: flex; opacity: 1; }
    .modal-box { background: white; border-radius: 12px; width: 90%; max-width: 600px; padding: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transform: translateY(20px); transition: transform 0.3s; }
    .modal-overlay.open .modal-box { transform: translateY(0); }
    .code-block { background: #1e293b; color: #e2e8f0; padding: 16px; border-radius: 8px; font-family: 'Fira Code', monospace; font-size: 14px; overflow-x: auto; margin: 16px 0; border: 1px solid #334155; }
  </style>
</head>
<body>

  <header class="app-header" style="background: white; border-bottom: 1px solid #e5e7eb; padding: 16px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 0 24px;">
      <a href="{{ route('dashboard') }}" class="brand" style="text-decoration: none; color: #1e293b; font-weight: 700; font-size: 20px; display: flex; align-items: center; gap: 8px;">
        <img src="{{ asset('assets/logo.svg') }}" class="logo">
                <span class="brand-name">CodePlay</span>

      </a>
      <nav class="app-nav" style="display: flex; gap: 24px;">
        <span class="nav-link font-bold" style="color: #64748b;">{{ $step->tutorial->course->title ?? 'Belajar Coding' }}</span>
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
  <main style="max-width: 1200px; margin: 32px auto; padding: 0 24px;">
    
    <div style="margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
            <div style="display: flex; gap: 16px; align-items: center;">
                <div style="background: white; padding: 10px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <i class="fa-solid fa-code" style="font-size: 24px; color: #3b82f6;"></i>
                </div>
                <div>
                    <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $step->tutorial->title ?? 'Javascript Fundamentals' }}</h1>
                    <p style="color: #64748b; margin: 4px 0 0 0; font-size: 14px;">Materi Pembelajaran Interaktif</p>
                </div>
            </div>
            
            <!-- Logic: Cari Quiz yang berhubungan dengan Course ini -->
            @php
                $relatedQuiz = \App\Models\Quiz::where('course_id', $step->tutorial->course_id)->first();
            @endphp

            @if($relatedQuiz)
                <a href="{{ route('quiz.show', $relatedQuiz->quiz_id) }}" class="btn-prev" style="text-decoration: none; padding: 10px 24px; color: #1e293b; font-weight: 600; border: 1px solid #cbd5e1; display: inline-block;">
                    Ambil Quiz
                </a>
            @else
                <button class="btn-prev" disabled style="opacity: 0.5; cursor: not-allowed; text-decoration: none; padding: 10px 24px; color: #94a3b8; font-weight: 600; border: 1px solid #e2e8f0;">
                    Quiz Belum Tersedia
                </button>
            @endif
        </div>

        @php $percentage = ($step->step_number / $totalSteps) * 100; @endphp
        <div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #475569;">
                <span>Progress Tutorial</span>
                <span>{{ round($percentage) }}%</span>
            </div>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                <div style="width: {{ $percentage }}%; height: 100%; background: #3b82f6; border-radius: 4px; transition: width 0.5s;"></div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 40% 58%; gap: 2%;">
        
        <div class="card-box" style="display: flex; flex-direction: column; min-height: 500px;">
            
            <div style="color: #3b82f6; font-weight: 600; font-size: 14px; margin-bottom: 8px;">
                Langkah {{ $step->step_number }} dari {{ $totalSteps }}
            </div>

            <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">
                {{ $step->title }}
            </h2>

            <div class="instruction-box">
                {!! nl2br(e($step->instruction)) !!}
                
                <div style="margin-top: 16px; font-weight: 600; color: #1e293b;">Tugas Anda:</div>
                <ul style="margin: 8px 0 0 20px; padding: 0;">
                    <li>Baca instruksi dengan teliti.</li>
                    <li>Tulis kode di editor sebelah kanan.</li>
                    <li>Klik tombol "Jalankan" untuk cek hasil.</li>
                </ul>

                @if($step->hint)
                    <div style="margin-top: 16px; border-top: 1px dashed #bfdbfe; padding-top: 12px; font-size: 13px; color: #2563eb;">
                        <i class="fa-solid fa-lightbulb"></i> <strong>Hint:</strong> {{ $step->hint }}
                    </div>
                @endif
            </div>

            <div style="margin-top: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    @if($prevStep)
                        <a href="{{ route('tutorial.step', $prevStep->step_id) }}" class="btn-nav btn-prev" style="text-decoration: none;">
                            <i class="fa-solid fa-chevron-left"></i> Sebelumnya
                        </a>
                    @else
                        <button class="btn-nav btn-prev" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fa-solid fa-chevron-left"></i> Sebelumnya
                        </button>
                    @endif

                    @if($nextStep)
                        @if(session('success') || ($progress && $progress->is_completed))
                            <a href="{{ route('tutorial.step', $nextStep->step_id) }}" class="btn-nav btn-next" style="text-decoration: none;">
                                Selanjutnya <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        @else
                             <button class="btn-nav btn-next" disabled style="opacity: 0.5; cursor: not-allowed; background: #94a3b8; border-color: #94a3b8;">
                                Selanjutnya <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        @endif
                    @else
                        <a href="{{ route('tutorials.index') }}" class="btn-nav btn-next" style="background: #10b981; border-color: #10b981; text-decoration: none;">
                            Selesai <i class="fa-solid fa-check"></i>
                        </a>
                    @endif
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button onclick="openSolution()" style="background: none; border: none; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; transition: background 0.2s;">
                        <i class="fa-solid fa-eye"></i> Lihat Solusi
                    </button>
                </div>
            </div>
        </div>


        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <form action="{{ route('tutorial.submit', $step->step_id) }}" method="POST">
                @csrf
                
                <div class="card-box" style="padding: 0; overflow: hidden; border: 1px solid #cbd5e1;">
                    <div style="background: white; padding: 12px 16px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 600; color: #475569; font-size: 14px;">
                            {{ $step->title }}
                        </span>
                        
                        <button type="submit" class="btn-run">
                            <i class="fa-solid fa-play"></i> Jalankan
                        </button>
                    </div>

                    <textarea 
                        name="user_code" 
                        class="editor-dark" 
                        spellcheck="false"
                        placeholder="// Tulis kode Anda di sini..."
                    >{{ old('user_code', $progress->user_code ?? $step->code_template) }}</textarea>
                </div>
            </form>

            <div class="card-box" style="min-height: 200px; display: flex; flex-direction: column;">
                <div style="font-weight: 600; color: #475569; font-size: 14px; margin-bottom: 12px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                    Output
                </div>
                
                <div style="flex-grow: 1; font-family: 'Fira Code', monospace; font-size: 13px;">
                    
                    @if(session('success'))
                        <div style="color: #15803d;">
                            <i class="fa-solid fa-check"></i> System Output:<br>
                            > Process finished with exit code 0<br>
                            > <span style="font-weight: bold;">{{ session('success') }}</span>
                        </div>
                    @elseif(session('error'))
                        <div style="color: #b91c1c;">
                            <i class="fa-solid fa-times"></i> System Output:<br>
                            > Syntax Error / Logic Incorrect<br>
                            > <span style="font-weight: bold;">{{ session('error') }}</span>
                        </div>
                    @else
                        <span style="color: #94a3b8;">Output akan muncul disini setelah Anda klik "Jalankan"...</span>
                    @endif

                </div>
            </div>

        </div>

    </div>

    <div id="solutionModal" class="modal-overlay">
      <div class="modal-box">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
              <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0;">Kunci Jawaban</h3>
              <button onclick="closeSolution()" style="background: none; border: none; font-size: 24px; color: #94a3b8; cursor: pointer;">&times;</button>
          </div>
          
          <p style="color: #64748b; font-size: 14px; margin-bottom: 16px;">
              Gunakan kode di bawah ini sebagai referensi belajar jika Anda mengalami kesulitan.
          </p>

          <!-- Code Block Solusi -->
          <pre class="code-block">{{ $step->solution_code }}</pre>

          <div style="text-align: right; margin-top: 24px;">
              <button onclick="closeSolution()" class="btn-prev" style="cursor: pointer;">Tutup</button>
              <button onclick="copySolution()" class="btn-next" style="cursor: pointer; margin-left: 8px;">
                  <i class="fa-regular fa-copy"></i> Salin Kode
              </button>
          </div>
      </div>
  </div>
  </main>

  <script>
    // Tab indent handler
    document.querySelector('textarea').addEventListener('keydown', function(e) {
      if (e.key == 'Tab') {
        e.preventDefault();
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.substring(0, start) + "\t" + this.value.substring(end);
        this.selectionStart = this.selectionEnd = start + 1;
      }
    });
     const modal = document.getElementById('solutionModal');

    function openSolution() {
        modal.classList.add('open');
    }

    function closeSolution() {
        modal.classList.remove('open');
    }

    // Klik di luar modal buat nutup
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeSolution();
        }
    });

    // Fitur Copy Code
    function copySolution() {
        const code = document.querySelector('.code-block').innerText;
        navigator.clipboard.writeText(code).then(() => {
            alert('Kode berhasil disalin!');
            closeSolution();
        });
    }
  </script>
</body>
</html>