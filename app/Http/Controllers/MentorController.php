<?php


namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MentorController extends Controller
{

    public function dashboard()
    {
        $mentorId = Auth::id();
        

        $courses = Course::where('mentor_id', $mentorId)->get();
        

        $materials = CourseMaterial::whereIn('course_id', $courses->pluck('course_id'))
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();
        

        $totalVideos = $materials->where('type', 'video')->count();
        $publishedVideos = $materials->where('type', 'video')
            ->filter(function($material) {
                return $material->is_published ?? true;
            })->count();
        $draftVideos = $totalVideos - $publishedVideos;
        $totalViews = $materials->sum('views') ?? 0;
        
        return view('mentor.dashboard', compact(
            'materials',
            'courses',
            'totalVideos',
            'publishedVideos',
            'draftVideos',
            'totalViews'
        ));
    }


    public function storeMaterial(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,course_id',
            'title' => 'required|max:200',
            'video' => 'required|file|mimes:mp4|max:102400',
        ]);


        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials/videos', $fileName, 'public');
            


            $duration = 0;
            
            CourseMaterial::create([
                'course_id' => $request->course_id,
                'title' => $request->title,
                'type' => 'video',
                'file_url' => $filePath,
                'order_index' => 0,
                'duration' => $duration,
                'is_published' => $request->has('is_published') ? true : false,
            ]);

            return redirect()->route('mentor.dashboard')
                ->with('success', "Video '{$request->title}' berhasil ditambahkan!");
        }

        return redirect()->back()->with('error', 'Gagal upload video!');
    }


    public function deleteMaterial($materialId)
    {
        $material = CourseMaterial::findOrFail($materialId);
        

        $course = $material->course;
        if ($course->mentor_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }


        if ($material->file_url) {
            Storage::disk('public')->delete($material->file_url);
        }

        $materialTitle = $material->title;
        $material->delete();

        return redirect()->route('mentor.dashboard')
            ->with('success', "Video '{$materialTitle}' berhasil dihapus!");
    }


    public function editMaterial($materialId)
    {
        $material = CourseMaterial::with('course')->findOrFail($materialId);
        

        if ($material->course->mentor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('mentor.materials.edit', compact('material'));
    }
}