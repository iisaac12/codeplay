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
    

    .timer-badge { 
        background: #93c5fd; 
        color: #1e3a8a; 
        padding: 8px 24px; 
        border-radius: 99px; 
        font-weight: 600; 
        font-size: 18px; 
        display: flex; 
        align-items: center; 
        gap: 10px;
    }

    
    .progress-section { padding: 20px 40px 0; max-width: 1000px; margin: 0 auto; }
    .progress-info { display: flex; justify-content: space-between; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px; }
    .progress-track { width: 100%; height: 10px; background: #e5e7eb; border-radius: 99px; overflow: hidden; }
    .progress-fill { height: 100%; background: #000000; width: 0%; transition: width 0.3s ease; border-radius: 99px; }

    
    .main-container { max-width: 900px; margin: 20px auto 60px; padding: 0 24px; }
    
    .question-card { 
        background: #f3f4f6; 
        border-radius: 40px; 
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

    
    .options-list { display: flex; flex-direction: column; gap: 16px; }
    
    .option-item { 
        background: #e5e5e5; 
        border: 2px solid #d4d4d4; 
        border-radius: 16px; 
        padding: 16px 24px; 
        cursor: pointer; 
        transition: all 0.2s; 
        display: flex; 
        align-items: center; 
        gap: 20px; 
        box-shadow: 0 2px 0 rgba(0,0,0,0.05);
    }
    
    .option-item:hover { background: #d4d4d4; }
    
    
    .option-item.selected { 
        background: #e5e5e5; 
        border-color: #6366f1; 
        box-shadow: 0 0 0 1px #6366f1;
    }
    
    
    .radio-circle { 
        width: 24px; height: 24px; border-radius: 50%; background: #d4d4d4; 
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .option-item.selected .radio-circle { background: #6366f1; } 
    
    .option-text { font-weight: 700; color: #1f2937; font-size: 16px; }

    
    .nav-buttons { 
        display: flex; justify-content: space-between; align-items: center; 
        margin-top: auto; padding-top: 30px; border-top: 1px solid #9ca3af; 
    }
    
    .btn-nav { 
        background: #4338ca; 
        color: white; border: none; padding: 12px 32px; 
        border-radius: 8px; font-weight: 700; cursor: pointer; transition: background 0.2s; 
        font-size: 14px;
    }
    .btn-nav:hover { background: #3730a3; }
    .btn-nav:disabled { background: #9ca3af; cursor: not-allowed; opacity: 0.8; }

    
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
    
    
    .hidden { display: none !important; }
    .coding-area { width: 100%; padding: 16px; border-radius: 12px; border: 2px solid #d4d4d4; font-family: monospace; min-height: 150px; background: white; }
  </style>
</head>
<body>

  
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
    
    
    <div class="timer-badge">
        <i class="fa-regular fa-clock"></i> 
        <span id="timerText">00:00</span>
    </div>
  </header>

  
  <div class="progress-section">
    <div class="progress-info">
        <span id="questionCounter">Pertanyaan 1 dari {{ $quiz->questions->count() }}</span>
        <span id="progressPercentage" style="color: #3b82f6; font-weight: 600;">0%</span>
    </div>
    <div class="progress-track">
        <div class="progress-fill" id="progressBar"></div>
    </div>
  </div>

  
  <div class="main-container">
    <form id="quizForm" action="{{ route('quiz.submit', $attempt->attempt_id) }}" method="POST">
        @csrf
        
        <div class="question-card">
            
            
            @foreach($quiz->questions as $index => $question)
                <div class="question-slide {{ $index === 0 ? '' : 'hidden' }}" data-index="{{ $index }}">
                    
                    
                    <p class="question-text">{!! nl2br(e($question->question_text)) !!}</p>

                    
                    @if($question->question_type === 'multiple_choice')
                        <div class="options-list">
                            @foreach($question->options as $option)
                                <label class="option-item" onclick="selectOption(this)">
                                    <div class="radio-circle"></div>
                                    
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


            <div class="card-footer">
                
                
                <div class="nav-buttons">
                    <button type="button" class="btn-nav secondary" id="btnPrev" disabled onclick="prevQuestion()">Sebelumnya</button>
                    
                    <button type="button" class="btn-nav" id="btnNext" onclick="nextQuestion()">Selanjutnya</button>
                    
                    <button type="submit" class="btn-nav hidden" id="btnSubmit" onclick="return confirm('Yakin ingin submit?')">Selesai</button>
                </div>

                
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

  
  <script>
    
    const totalQuestions = {{ $quiz->questions->count() }};
    let currentIndex = 0;
    
    
    const timerText = document.getElementById('timerText');
    
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

    
    function updateUI() {
        
        document.querySelectorAll('.question-slide').forEach((el, idx) => {
            el.classList.toggle('hidden', idx !== currentIndex);
        });

        
        document.querySelectorAll('.page-dot').forEach((el, idx) => {
            el.classList.toggle('active', idx === currentIndex);
        });

        
        document.getElementById('btnPrev').disabled = currentIndex === 0;
        
        if (currentIndex === totalQuestions - 1) {
            document.getElementById('btnNext').classList.add('hidden');
            document.getElementById('btnSubmit').classList.remove('hidden');
        } else {
            document.getElementById('btnNext').classList.remove('hidden');
            document.getElementById('btnSubmit').classList.add('hidden');
        }

        
        document.getElementById('questionCounter').innerText = `Pertanyaan ${currentIndex + 1} dari ${totalQuestions}`;
        
        
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

    
    function selectOption(label) {
        
        const slide = label.closest('.question-slide');
        
        
        slide.querySelectorAll('.option-item').forEach(el => el.classList.remove('selected'));
        
        
        label.classList.add('selected');
        
        
        const radio = label.querySelector('input[type="radio"]');
        if(radio) radio.checked = true;
    }

    
    updateUI();
  </script>

</body>
</html>