<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingUsers = User::where('is_verified', false)->count();
        $pendingCourses = Course::where('is_verified', false)->count();
        $totalUsers = User::count();
        $totalCourses = Course::count();

        $users = User::withCount('enrollments')
            ->orderBy('created_at', 'desc')
            ->get();

        $courses = Course::with(['mentor', 'category'])
            ->withCount('enrollments')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'pendingUsers',
            'pendingCourses',
            'totalUsers',
            'totalCourses',
            'users',
            'courses'
        ));
    }

    public function verifyUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->is_verified = true;
        $user->save();

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'verify_user',
            'target_type' => 'user',
            'target_id' => $userId,
            'description' => "Verified user: {$user->username}"
        ]);

        return redirect()->back()->with('success', "User {$user->full_name} berhasil diverifikasi!");
    }

    public function verifyCourse($courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->is_verified = true;
        $course->save();

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'verify_course',
            'target_type' => 'course',
            'target_id' => $courseId,
            'description' => "Verified course: {$course->title}"
        ]);

        return redirect()->back()->with('success', "Kursus {$course->title} berhasil diverifikasi!");
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($userId == Auth::id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $userName = $user->full_name;
        $user->delete();

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'delete_user',
            'target_type' => 'user',
            'target_id' => $userId,
            'description' => "Deleted user: {$userName}"
        ]);

        return redirect()->back()->with('success', "User {$userName} berhasil dihapus!");
    }

    public function deleteCourse($courseId)
    {
        $course = Course::findOrFail($courseId);
        $courseTitle = $course->title;
        $course->delete();

        AdminLog::create([
            'admin_id' => Auth::id(),
            'action' => 'delete_course',
            'target_type' => 'course',
            'target_id' => $courseId,
            'description' => "Deleted course: {$courseTitle}"
        ]);

        return redirect()->back()->with('success', "Kursus {$courseTitle} berhasil dihapus!");
    }
}