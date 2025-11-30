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

    public function show($quizId)
    {
        $quiz = Quiz::with(['course'])->findOrFail($quizId);
        return view('quizzes.show', compact('quiz'));
    }


    public function start($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);


        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quizId,
            'started_at' => now(),
            'score' => 0,
            'is_passed' => 0,

            'max_score' => $quiz->questions->sum('points') ?? 0
        ]);


        return redirect()->route('quiz.attempt', $attempt->attempt_id);
    }


    public function attempt($attemptId)
    {
        $attempt = QuizAttempt::findOrFail($attemptId);


        if ($attempt->user_id != Auth::id()) {
            abort(403, 'Akses ditolak. Ini bukan sesi kuis Anda.');
        }


        if ($attempt->submitted_at) {
            return redirect()->route('quiz.result', $attemptId);
        }


        $quiz = Quiz::with(['questions.options'])->findOrFail($attempt->quiz_id);

        return view('quizzes.attempt', compact('quiz', 'attempt'));
    }


    public function submit(Request $request, $attemptId)
    {

        $attempt = QuizAttempt::with(['quiz.questions.options', 'quiz.questions.codingTests'])
            ->findOrFail($attemptId);


        if ($attempt->user_id != Auth::id()) {
            abort(403);
        }
        
        $totalScore = 0;
        $answers = $request->input('answers', []);


        foreach ($attempt->quiz->questions as $question) {
            

            $userAnswerValue = $answers[$question->question_id] ?? null;
            
            $isCorrect = false;
            $pointsEarned = 0;
            $answerText = null;
            $selectedOptionId = null;


            if ($question->question_type === 'multiple_choice') {

                $correctOption = $question->options->where('is_correct', true)->first();
                

                $selectedOptionId = $userAnswerValue;
                
                if ($correctOption && $correctOption->option_id == $userAnswerValue) {
                    $isCorrect = true;
                    $pointsEarned = $question->points;
                }


            } elseif ($question->question_type === 'coding') {
                $answerText = $userAnswerValue;
                


                $keyData = $question->codingTests->first();
                
                if ($keyData) {


                    $userClean = trim(strtolower($answerText ?? ''));
                    $keyClean = trim(strtolower($keyData->expected_output ?? ''));
                    

                    if ($userClean === $keyClean && $userClean !== '') {
                        $isCorrect = true;
                        $pointsEarned = $question->points;
                    }
                } else {

                    $isCorrect = false; 
                }
            }


            UserAnswer::create([
                'attempt_id' => $attemptId,
                'question_id' => $question->question_id,
                'selected_option_id' => $selectedOptionId,
                'answer_text' => $answerText,
                'is_correct' => $isCorrect ? 1 : 0,
                'points_earned' => $pointsEarned,
                'answered_at' => now()
            ]);

            $totalScore += $pointsEarned;
        }


        $attempt->update([
            'score' => $totalScore,
            'submitted_at' => now(),

            'time_taken' => now()->diffInSeconds($attempt->started_at),
            'is_passed' => $totalScore >= ($attempt->quiz->passing_score ?? 70) ? 1 : 0
        ]);

        return redirect()->route('quiz.result', $attemptId);
    }


    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz', 'answers.question', 'answers.selectedOption'])
            ->findOrFail($attemptId);
            

        if ($attempt->user_id != Auth::id()) {
            abort(403);
        }

        return view('quizzes.result', compact('attempt'));
    }
}