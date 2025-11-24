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
    // Tampilkan quiz
    public function show($quizId)
    {
        $quiz = Quiz::with(['course', 'questions.options'])->findOrFail($quizId);
        
        return view('quizzes.show', compact('quiz'));
    }

    // Mulai quiz
    public function start($quizId)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quizId);

        // Create attempt
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quizId,
            'started_at' => now(),
            'max_score' => $quiz->questions->sum('points')
        ]);

        return view('quizzes.attempt', compact('quiz', 'attempt'));
    }

    // Submit quiz
    public function submit(Request $request, $attemptId)
    {
        $attempt = QuizAttempt::with('quiz.questions')->findOrFail($attemptId);
        
        $totalScore = 0;
        $answers = $request->input('answers', []);

        foreach ($answers as $questionId => $answer) {
            $question = Question::with(['options', 'codingTests'])->findOrFail($questionId);
            
            $isCorrect = false;
            $pointsEarned = 0;

            if ($question->question_type === 'multiple_choice') {
                $correctOption = $question->options->where('is_correct', true)->first();
                $isCorrect = $correctOption && $correctOption->option_id == $answer;
                $pointsEarned = $isCorrect ? $question->points : 0;

                UserAnswer::create([
                    'attempt_id' => $attemptId,
                    'question_id' => $questionId,
                    'selected_option_id' => $answer,
                    'is_correct' => $isCorrect,
                    'points_earned' => $pointsEarned
                ]);
            } elseif ($question->question_type === 'coding') {
                // TODO: Run code against test cases
                $isCorrect = false; // Placeholder
                $pointsEarned = $isCorrect ? $question->points : 0;

                UserAnswer::create([
                    'attempt_id' => $attemptId,
                    'question_id' => $questionId,
                    'answer_text' => $answer,
                    'is_correct' => $isCorrect,
                    'points_earned' => $pointsEarned
                ]);
            }

            $totalScore += $pointsEarned;
        }

        // Update attempt
        $attempt->score = $totalScore;
        $attempt->submitted_at = now();
        $attempt->time_taken = now()->diffInSeconds($attempt->started_at);
        $attempt->is_passed = $totalScore >= $attempt->quiz->passing_score;
        $attempt->save();

        return redirect()->route('quiz.result', $attemptId);
    }

    // Hasil quiz
    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz', 'answers.question', 'answers.selectedOption'])
            ->findOrFail($attemptId);

        return view('quizzes.result', compact('attempt'));
    }
}
