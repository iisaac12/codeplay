<?php
namespace App\Http\Controllers;

use App\Models\UserEnrollment;
use App\Models\MaterialProgress;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $enrollments = UserEnrollment::where('user_id', Auth::id())
            ->with('course')
            ->orderBy('enrolled_at', 'desc')
            ->get();

        $totalQuizzes = QuizAttempt::where('user_id', Auth::id())->count();
        $passedQuizzes = QuizAttempt::where('user_id', Auth::id())
            ->where('is_passed', true)
            ->count();

        $totalMaterials = MaterialProgress::where('user_id', Auth::id())->count();
        $completedMaterials = MaterialProgress::where('user_id', Auth::id())
            ->where('is_completed', true)
            ->count();

        return view('progress.index', compact(
            'enrollments',
            'totalQuizzes',
            'passedQuizzes',
            'totalMaterials',
            'completedMaterials'
        ));
    }
}