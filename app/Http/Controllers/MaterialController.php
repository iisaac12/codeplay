<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\MaterialProgress;
use App\Models\UserEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Menampilkan daftar materi
     */
    public function index()
    {
        $user = Auth::user(); // <--- TAMBAHKAN INI
        $userId = $user->user_id; // Atau Auth::id()

        // 1. Ambil daftar ID kursus yang diikuti user saat ini
        $enrolledCourseIds = UserEnrollment::where('user_id', $userId)
            ->pluck('course_id');

        // 2. Ambil materi yang course_id-nya ada di daftar enrollment tersebut
        $materials = CourseMaterial::whereIn('course_id', $enrolledCourseIds)
            ->with('course') 
            ->orderBy('created_at', 'desc') 
            ->paginate(10); 

        // Jangan lupa kirim 'user' ke view
        return view('materials.index', compact('materials', 'user'));
    }
    
    // Tampilkan detail materi
    public function show($materialId)
    {
        $user = Auth::user(); // <--- Tambahkan ini juga biar aman

        $material = CourseMaterial::where('material_id', $materialId)->firstOrFail();
        $course = $material->course;

        $course->load(['materials', 'tutorials', 'quizzes']);

        $enrollment = UserEnrollment::where('user_id', $user->user_id)
            ->where('course_id', $course->course_id)
            ->firstOrFail();

        $progress = MaterialProgress::firstOrCreate([
            'user_id' => $user->user_id,
            'material_id' => $materialId
        ]);

        // Kirim 'user' ke view
        return view('materials.show', compact('material', 'course', 'enrollment', 'progress', 'user'));
    }

    // Update progress materi (Mark as Completed)
    public function updateProgress(Request $request, $materialId)
    {
        $progress = MaterialProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'material_id' => $materialId
        ]);

        $progress->last_position = $request->input('position', 0);
        
        if ($request->has('completed') && $request->completed) {
            $progress->is_completed = true;
            $progress->completed_at = now();
        }
        
        $progress->save();

        $this->updateEnrollmentProgress($materialId);

        return redirect()->back()->with('success', 'Materi berhasil diselesaikan! Progres tersimpan.');
    }

    // Download file materi
    public function download($materialId)
    {
        $material = CourseMaterial::findOrFail($materialId);

        // Cek tipe materi: Jika text atau code, tolak download
        if (in_array($material->type, ['text', 'code'])) {
            return redirect()->back()->with('error', 'Materi bertipe Teks atau Kode tidak dapat diunduh.');
        }

        \App\Models\Download::create([
            'user_id' => Auth::id(),
            'material_id' => $materialId
        ]);

        // Cek file
        if (Storage::disk('public')->exists($material->file_url)) {
             return Storage::disk('public')->download($material->file_url);
        }
        
        $path = 'public/' . $material->file_url;
        if (Storage::exists($path)) {
            return Storage::download($path);
        } 
        
        return redirect()->back()->with('error', 'Maaf, file fisik tidak ditemukan di server.');
    }

    // Stream PDF
    public function streamPdf($id)
    {
        $material = \App\Models\CourseMaterial::findOrFail($id);
        $filename = $material->file_url; 

        if (Storage::disk('public')->exists($filename)) {
            $fullPath = Storage::disk('public')->path($filename);

            return response()->file($fullPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($filename) . '"'
            ]);
        }

        return abort(404, 'File PDF tidak ditemukan');
    }

    // Helper
    private function updateEnrollmentProgress($materialId)
    {
        $material = CourseMaterial::findOrFail($materialId);
        $courseId = $material->course_id;

        $totalMaterials = CourseMaterial::where('course_id', $courseId)->count();
        
        $completedMaterials = MaterialProgress::where('user_id', Auth::id())
            ->whereHas('material', function($q) use ($courseId) {
                $q->where('course_id', $courseId);
            })
            ->where('is_completed', true)
            ->count();

        $progress = $totalMaterials > 0 ? round(($completedMaterials / $totalMaterials) * 100, 2) : 0;

        $updateData = ['progress_percentage' => $progress];
        
        if ($progress >= 100) {
            $updateData['completed_at'] = now();
        } else {
            $updateData['completed_at'] = null; 
        }

        UserEnrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->update($updateData);
    }
}