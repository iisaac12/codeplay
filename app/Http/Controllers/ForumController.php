<?php

namespace App\Http\Controllers;

use App\Models\ForumThread;
use App\Models\Category;
use App\Models\Course;
use App\Models\ForumReply; // Pastikan model Reply di-use
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Menampilkan daftar diskusi
    public function index(Request $request)
    {
        $user = Auth::user(); // <--- TAMBAHKAN INI

        // 1. Query Dasar
        $query = ForumThread::with(['user', 'course.category'])
            ->withCount('replies');

        // 2. Fitur Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // 3. Filter berdasarkan Kategori
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('course.category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // 4. Urutkan
        $threads = $query->orderBy('is_pinned', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        // 5. Kategori Sidebar
        $categories = Category::all();

        // Kirim 'user' ke view
        return view('forum.index', compact('threads', 'categories', 'user'));
    }

    // Tampilkan Detail Thread
    public function show($id)
    {
        $user = Auth::user(); // <--- TAMBAHKAN INI

        $thread = ForumThread::with(['user', 'replies.user', 'course'])
            ->withCount('replies')
            ->findOrFail($id);

        $thread->increment('view_count');

        // Kirim 'user' ke view
        return view('forum.show', compact('thread', 'user'));
    }

    // Form Buat Pertanyaan Baru
    public function create()
    {
        $user = Auth::user(); // <--- TAMBAHKAN INI (Penyebab Error Tadi)
        
        $courses = Course::all();
        
        // Kirim 'user' ke view
        return view('forum.create', compact('courses', 'user'));
    }

    // Simpan Pertanyaan Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
            'course_id' => 'nullable|exists:courses,course_id'
        ]);

        ForumThread::create([
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'title' => $request->title,
            'content' => $request->content,
            'is_pinned' => false,
            'view_count' => 0
        ]);

        return redirect()->route('forum.index')->with('success', 'Pertanyaan berhasil diposting!');
    }

    // Kirim Balasan (Reply)
    public function reply(Request $request, $id)
    {
        $request->validate(['content' => 'required']);

        ForumReply::create([
            'thread_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_solution' => false
        ]);

        return redirect()->back()->with('success', 'Balasan terkirim!');
    }
}