<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEnrollment;
use App\Models\QuizAttempt;
use Carbon\Carbon;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // <--- TAMBAHKAN INI (Ambil data user lengkap)
        $userId = $user->user_id; // Gunakan ID dari objek user

        // 1. Statistik Kartu Atas
        $completedCourses = UserEnrollment::where('user_id', $userId)
            ->where(function($q) {
                $q->whereNotNull('completed_at')
                  ->orWhere('progress_percentage', '>=', 100);
            })
            ->count();

        // Hitung Rata-rata Skor Kuis
        $attempts = QuizAttempt::where('user_id', $userId)->get();
        $totalPercentage = 0;
        $attemptCount = $attempts->count();

        if ($attemptCount > 0) {
            foreach ($attempts as $attempt) {
                if ($attempt->max_score > 0) {
                    $totalPercentage += ($attempt->score / $attempt->max_score) * 100;
                }
            }
            $averageScore = round($totalPercentage / $attemptCount);
        } else {
            $averageScore = 0;
        }

        // Hitung Streak
        $streak = $this->calculateStreak($userId);

        // 2. Data Grafik Lingkaran
        $totalEnrolled = UserEnrollment::where('user_id', $userId)->count();
        $completionRate = $totalEnrolled > 0 ? round(($completedCourses / $totalEnrolled) * 100) : 0;

        // 3. Data Grafik Batang
        $recentAttempts = QuizAttempt::with('quiz')
            ->where('user_id', $userId)
            ->orderBy('started_at', 'desc')
            ->take(5)
            ->get()
            ->reverse();

        // Kirim $user ke view
        return view('progress.index', compact(
            'user', // <--- PENTING: Kirim variabel user
            'completedCourses', 
            'averageScore', 
            'streak', 
            'completionRate', 
            'recentAttempts',
            'totalEnrolled'
        ));
    }

    private function calculateStreak($userId)
    {
        $dates = QuizAttempt::where('user_id', $userId)
            ->orderBy('started_at', 'desc')
            ->pluck('started_at')
            ->map(function ($date) {
                return $date->format('Y-m-d');
            })
            ->unique()
            ->values();

        $streak = 0;
        
        if ($dates->isEmpty()) return 0;

        $today = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        
        if ($dates[0] != $today && $dates[0] != $yesterday) {
            return 0;
        }

        $checkDate = ($dates[0] == $today) ? Carbon::now() : Carbon::yesterday();

        foreach ($dates as $date) {
            if ($date == $checkDate->format('Y-m-d')) {
                $streak++;
                $checkDate->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }
}