<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QuizController extends Controller
{
    // 1. Tampilkan Halaman Intro Quiz
    public function show($quizId)
    {
        $quiz = Quiz::with(['course'])->findOrFail($quizId);
        return view('quizzes.show', compact('quiz'));
    }

    // 2. Proses Mulai (POST) -> Buat Data -> Redirect
    public function start($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);

        // Buat record attempt baru
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quizId,
            'started_at' => now(),
            'score' => 0,
            'is_passed' => 0,
            // Hitung max score dari total poin semua soal
            'max_score' => $quiz->questions->sum('points') ?? 0
        ]);

        // Redirect ke halaman pengerjaan (GET) dengan ID attempt yang baru dibuat
        return redirect()->route('quiz.attempt', $attempt->attempt_id);
    }

    // 3. Halaman Pengerjaan Soal (GET)
    public function attempt($attemptId)
    {
        $attempt = QuizAttempt::findOrFail($attemptId);

        // Security Check: Pastikan yang buka adalah pemilik attempt
        if ($attempt->user_id != Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan sesi kuis Anda.');
        }

        // Cek jika sudah disubmit, lempar ke hasil
        if ($attempt->submitted_at) {
            return redirect()->route('quiz.result', $attemptId);
        }

        // Ambil quiz beserta soal dan opsi jawaban
        $quiz = Quiz::with(['questions.options'])->findOrFail($attempt->quiz_id);

        return view('quizzes.attempt', compact('quiz', 'attempt'));
    }

    // 4. Submit Jawaban (POST)
    public function submit(Request $request, $attemptId)
    {
        // Load attempt beserta soal, opsi, DAN coding_tests (Kunci Jawaban Isian)
        $attempt = QuizAttempt::with(['quiz.questions.options', 'quiz.questions.codingTests'])
            ->findOrFail($attemptId);

        // Security Check
        if ($attempt->user_id != Auth::id()) {
            abort(403);
        }
        
        $totalScore = 0;
        $answers = $request->input('answers', []); // Array dari form: [question_id => answer_value]

        // Loop berdasarkan SOAL yang ada di database
        foreach ($attempt->quiz->questions as $question) {
            
            // Ambil jawaban user untuk soal ini
            $userAnswerValue = $answers[$question->question_id] ?? null;
            
            $isCorrect = false;
            $pointsEarned = 0;
            $answerText = null;
            $selectedOptionId = null;

            // --- LOGIKA PILIHAN GANDA ---
            if ($question->question_type === 'multiple_choice') {
                // Cari opsi yang benar dari relasi
                $correctOption = $question->options->where('is_correct', true)->first();
                
                // Cek jawaban (bandingkan option_id)
                $selectedOptionId = $userAnswerValue;
                
                if ($correctOption && $correctOption->option_id == $userAnswerValue) {
                    $isCorrect = true;
                    $pointsEarned = $question->points;
                }

            // --- LOGIKA ISIAN / CODING (UPDATE UTAMA) ---
            } elseif ($question->question_type === 'coding') {
                $answerText = $userAnswerValue;
                
                // Ambil Kunci Jawaban dari tabel coding_tests
                // Kita ambil data pertama sebagai kunci jawaban (expected_output)
                $keyData = $question->codingTests->first();
                
                if ($keyData) {
                    // Bersihkan input user & kunci jawaban (hapus spasi depan/belakang & lowercase)
                    // Supaya "Laravel" sama dengan "laravel " (lebih fleksibel)
                    $userClean = trim(strtolower($answerText ?? ''));
                    $keyClean = trim(strtolower($keyData->expected_output ?? ''));
                    
                    // Bandingkan
                    if ($userClean === $keyClean && $userClean !== '') {
                        $isCorrect = true;
                        $pointsEarned = $question->points;
                    }
                } else {
                    // Jika tidak ada kunci jawaban di database, otomatis SALAH (atau perlu review manual)
                    $isCorrect = false; 
                }
            }

            // Simpan detail jawaban ke tabel user_answers
            UserAnswer::create([
                'attempt_id' => $attemptId,
                'question_id' => $question->question_id,
                'selected_option_id' => $selectedOptionId, // Bisa null jika coding
                'answer_text' => $answerText, // Bisa null jika PG
                'is_correct' => $isCorrect ? 1 : 0,
                'points_earned' => $pointsEarned,
                'answered_at' => now()
            ]);

            $totalScore += $pointsEarned;
        }

        // Update hasil akhir attempt
        $attempt->update([
            'score' => $totalScore,
            'submitted_at' => now(),
            // Hitung durasi (detik)
            'time_taken' => now()->diffInSeconds($attempt->started_at),
            'is_passed' => $totalScore >= ($attempt->quiz->passing_score ?? 70) ? 1 : 0
        ]);

        return redirect()->route('quiz.result', $attemptId);
    }

    // 5. Halaman Hasil
    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz', 'answers.question', 'answers.selectedOption'])
            ->findOrFail($attemptId);
            
        // Security Check
        if ($attempt->user_id != Auth::id()) {
            abort(403);
        }

        return view('quizzes.result', compact('attempt'));
    }
}