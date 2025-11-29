<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $quiz->title }} — CodePlay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #ffffff; color: #1f2937; margin: 0; }
    
    /* === HEADER === */
    .quiz-header { 
        background: white; 
        border-bottom: 2px solid #f3f4f6; 
        padding: 16px 40px; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        height: 80px;
    }
    
    .header-left { display: flex; align-items: center; gap: 24px; }
    .home-icon { font-size: 24px; color: #4b5563; text-decoration: none; }
    
    .brand-area { display: flex; align-items: center; gap: 16px; }
    .brand-logo i { font-size: 32px; color: #1e293b; } 
    .quiz-title { font-size: 20px; font-weight: 500; color: #111827; }
    
    /* Timer Kapsul Biru Muda */
    .timer-badge { 
        background: #93c5fd; /* Biru langit */
        color: #1e3a8a; 
        padding: 8px 24px; 
        border-radius: 99px; 
        font-weight: 600; 
        font-size: 18px; 
        display: flex; 
        align-items: center; 
        gap: 10px;
    }

    /* === PROGRESS BAR === */
    .progress-section { padding: 20px 40px 0; max-width: 1000px; margin: 0 auto; }
    .progress-info { display: flex; justify-content: space-between; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px; }
    .progress-track { width: 100%; height: 10px; background: #e5e7eb; border-radius: 99px; overflow: hidden; }
    .progress-fill { height: 100%; background: #000000; width: 0%; transition: width 0.3s ease; border-radius: 99px; }

    /* === MAIN CARD CONTAINER === */
    .main-container { max-width: 900px; margin: 20px auto 60px; padding: 0 24px; }
    
    .question-card { 
        background: #f3f4f6; /* Abu-abu muda background card */
        border-radius: 40px; /* Rounded besar */
        padding: 50px 60px; 
        border: 1px solid #d1d5db; 
        position: relative; 
        min-height: 550px; 
        display: flex; 
        flex-direction: column;
    }
    
    .question-text { 
        font-size: 18px; 
        font-weight: 700; 
        color: #000; 
        margin-bottom: 32px; 
        text-align: left;
        line-height: 1.5;
    }

    /* === OPTIONS LIST (JAWABAN) === */
    .options-list { display: flex; flex-direction: column; gap: 16px; }
    
    .option-item { 
        background: #e5e5e5; /* Abu-abu default */
        border: 2px solid #d4d4d4; 
        border-radius: 16px; /* Rounded pill */
        padding: 16px 24px; 
        cursor: pointer; 
        transition: all 0.2s; 
        display: flex; 
        align-items: center; 
        gap: 20px; 
        box-shadow: 0 2px 0 rgba(0,0,0,0.05);
    }
    
    .option-item:hover { background: #d4d4d4; }
    
    /* State Terpilih */
    .option-item.selected { 
        background: #e5e5e5; /* Tetap abu-abu atau agak gelap */
        border-color: #6366f1; /* Border ungu/biru */
        box-shadow: 0 0 0 1px #6366f1;
    }
    
    /* Lingkaran Indikator */
    .radio-circle { 
        width: 24px; height: 24px; border-radius: 50%; background: #d4d4d4; 
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .option-item.selected .radio-circle { background: #6366f1; } /* Warna aktif */
    
    .option-text { font-weight: 700; color: #1f2937; font-size: 16px; }

    /* === FOOTER NAVIGASI === */
    .nav-buttons { 
        display: flex; justify-content: space-between; align-items: center; 
        margin-top: auto; padding-top: 30px; border-top: 1px solid #9ca3af; 
    }
    
    .btn-nav { 
        background: #4338ca; /* Indigo/Biru Tua */
        color: white; border: none; padding: 12px 32px; 
        border-radius: 8px; font-weight: 700; cursor: pointer; transition: background 0.2s; 
        font-size: 14px;
    }
    .btn-nav:hover { background: #3730a3; }
    .btn-nav:disabled { background: #9ca3af; cursor: not-allowed; opacity: 0.8; }

    /* === PAGINATION DOTS (1 2 3 4 5) === */
    .pagination-dots { 
        display: flex; justify-content: flex-start; gap: 12px; margin-top: 24px; 
        padding-top: 20px; border-top: 1px solid #d1d5db; 
    }
    .page-dot { 
        width: 40px; height: 40px; border-radius: 12px; border: none; 
        background: #4338ca; color: white; font-weight: 700; cursor: pointer; 
        font-size: 18px; display: flex; align-items: center; justify-content: center;
        transition: transform 0.2s;
    }
    .page-dot.active { transform: scale(1.1); box-shadow: 0 0 0 2px white, 0 0 0 4px #4338ca; }
    .page-dot:hover { opacity: 0.9; }
    
    /* UTILS */
    .hidden { display: none !important; }
    .coding-area { width: 100%; padding: 16px; border-radius: 12px; border: 2px solid #d4d4d4; font-family: monospace; min-height: 150px; background: white; }
  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="quiz-header">
    <div class="header-left">
        <a href="{{ route('dashboard') }}" class="home-icon">
            <i class="fa-solid fa-house"></i>
        </a>
        <div class="brand-area">
            <div class="brand-logo"><i class="fa-solid fa-pen-nib"></i></div> 
            <span class="quiz-title">{{ $quiz->title }}</span>
        </div>
    </div>
    
    <!-- Timer Kapsul -->
    <div class="timer-badge">
        <i class="fa-regular fa-clock"></i> 
        <span id="timerText">00:00</span>
    </div>
  </header>

  <!-- PROGRESS BAR -->
  <div class="progress-section">
    <div class="progress-info">
        <span id="questionCounter">Pertanyaan 1 dari {{ $quiz->questions->count() }}</span>
        <span id="progressPercentage" style="color: #3b82f6; font-weight: 600;">0%</span>
    </div>
    <div class="progress-track">
        <div class="progress-fill" id="progressBar"></div>
    </div>
  </div>

  <!-- MAIN CARD -->
  <div class="main-container">
    <form id="quizForm" action="{{ route('quiz.submit', $attempt->attempt_id) }}" method="POST">
        @csrf
        
        <div class="question-card">
            
            <!-- CONTAINER SOAL (LOOPING) -->
            @foreach($quiz->questions as $index => $question)
                <div class="question-slide {{ $index === 0 ? '' : 'hidden' }}" data-index="{{ $index }}">
                    
                    <!-- Text Soal -->
                    <p class="question-text">{!! nl2br(e($question->question_text)) !!}</p>

                    <!-- Pilihan Jawaban -->
                    @if($question->question_type === 'multiple_choice')
                        <div class="options-list">
                            @foreach($question->options as $option)
                                <label class="option-item" onclick="selectOption(this)">
                                    <div class="radio-circle"></div>
                                    <!-- Input Radio (Hidden) -->
                                    <input type="radio" name="answers[{{ $question->question_id }}]" value="{{ $option->option_id }}" class="hidden">
                                    <span class="option-text">{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($question->question_type === 'coding')
                        <textarea name="answers[{{ $question->question_id }}]" class="coding-area" placeholder="// Tulis jawaban kode Anda di sini..."></textarea>
                    @endif

                </div>
            @endforeach

            <!-- FOOTER NAVIGASI DALAM KARTU -->
            <div class="card-footer">
                
                <!-- Tombol Prev & Next -->
                <div class="nav-buttons">
                    <button type="button" class="btn-nav secondary" id="btnPrev" disabled onclick="prevQuestion()">Sebelumnya</button>
                    
                    <button type="button" class="btn-nav" id="btnNext" onclick="nextQuestion()">Selanjutnya</button>
                    
                    <button type="submit" class="btn-nav hidden" id="btnSubmit" onclick="return confirm('Yakin ingin submit?')">Selesai</button>
                </div>

                <!-- Pagination Dots (Angka 1 2 3...) -->
                <div class="pagination-dots">
                    @foreach($quiz->questions as $index => $question)
                        <button type="button" class="page-dot {{ $index === 0 ? 'active' : '' }}" onclick="jumpToQuestion({{ $index }})">
                            {{ $index + 1 }}
                        </button>
                    @endforeach
                </div>

            </div>

        </div>
    </form>
  </div>

  <!-- JAVASCRIPT LOGIC -->
  <script>
    // --- DATA DARI PHP ---
    const totalQuestions = {{ $quiz->questions->count() }};
    let currentIndex = 0;
    
    // --- TIMER ---
    const timerText = document.getElementById('timerText');
    // Ambil durasi dari DB (menit -> detik), default 30 menit
    let timeSeconds = {{ ($quiz->time_limit ?? 30) * 60 }};

    const timerInterval = setInterval(() => {
        const m = String(Math.floor(timeSeconds / 60)).padStart(2, '0');
        const s = String(timeSeconds % 60).padStart(2, '0');
        timerText.textContent = `${m}:${s}`;
        
        if (timeSeconds <= 0) {
            clearInterval(timerInterval);
            alert("Waktu Habis!");
            document.getElementById('quizForm').submit();
        }
        timeSeconds--;
    }, 1000);

    // --- NAVIGASI SOAL ---
    function updateUI() {
        // 1. Hide semua soal, Show soal saat ini
        document.querySelectorAll('.question-slide').forEach((el, idx) => {
            el.classList.toggle('hidden', idx !== currentIndex);
        });

        // 2. Update Pagination Dots (Tombol Angka)
        document.querySelectorAll('.page-dot').forEach((el, idx) => {
            el.classList.toggle('active', idx === currentIndex);
        });

        // 3. Update Tombol Prev/Next/Submit
        document.getElementById('btnPrev').disabled = currentIndex === 0;
        
        if (currentIndex === totalQuestions - 1) {
            document.getElementById('btnNext').classList.add('hidden');
            document.getElementById('btnSubmit').classList.remove('hidden');
        } else {
            document.getElementById('btnNext').classList.remove('hidden');
            document.getElementById('btnSubmit').classList.add('hidden');
        }

        // 4. Update Header Info
        document.getElementById('questionCounter').innerText = `Pertanyaan ${currentIndex + 1} dari ${totalQuestions}`;
        
        // Progress bar (Sesuai desain)
        const percentage = ((currentIndex + 1) / totalQuestions) * 100;
        document.getElementById('progressBar').style.width = `${percentage}%`;
        document.getElementById('progressPercentage').innerText = `${Math.round(percentage)}%`;
    }

    function nextQuestion() {
        if (currentIndex < totalQuestions - 1) {
            currentIndex++;
            updateUI();
        }
    }

    function prevQuestion() {
        if (currentIndex > 0) {
            currentIndex--;
            updateUI();
        }
    }

    function jumpToQuestion(index) {
        currentIndex = index;
        updateUI();
    }

    // --- LOGIC KLIK OPSI JAWABAN ---
    function selectOption(label) {
        // 1. Cari card soal saat ini
        const slide = label.closest('.question-slide');
        
        // 2. Hapus class 'selected' dari opsi lain di soal ini
        slide.querySelectorAll('.option-item').forEach(el => el.classList.remove('selected'));
        
        // 3. Tambah class 'selected' ke opsi yg diklik
        label.classList.add('selected');
        
        // 4. Pastikan radio button di dalamnya terpilih
        const radio = label.querySelector('input[type="radio"]');
        if(radio) radio.checked = true;
    }

    // Init UI Pertama Kali
    updateUI();
  </script>

</body>
</html>