<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard()
    {
        $pendingUsers = User::where('is_verified', false)->count();
        $pendingCourses = Course::where('is_verified', false)->count();
        $totalUsers = User::count();
        $totalCourses = Course::count();

        return view('admin.dashboard', compact(
            'pendingUsers',
            'pendingCourses',
            'totalUsers',
            'totalCourses'
        ));
    }

    // Verifikasi user
    public function verifyUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_verified = true;
        $user->save();

        // Log activity
        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'verify_user',
            'target_type' => 'user',
            'target_id' => $userId,
            'description' => "Verified user: {$user->username}"
        ]);

        return redirect()->back()->with('success', 'User berhasil diverifikasi!');
    }

    // Verifikasi course
    public function verifyCourse($courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->is_verified = true;
        $course->save();

        // Log activity
        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'verify_course',
            'target_type' => 'course',
            'target_id' => $courseId,
            'description' => "Verified course: {$course->title}"
        ]);

        return redirect()->back()->with('success', 'Kursus berhasil diverifikasi!');
    }

    // List pending verifications
    public function pendingVerifications()
    {
        $pendingUsers = User::where('is_verified', false)->get();
        $pendingCourses = Course::where('is_verified', false)->with('mentor')->get();

        return view('admin.verifications', compact('pendingUsers', 'pendingCourses'));
    }
}
