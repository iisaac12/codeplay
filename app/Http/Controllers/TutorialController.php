<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\TutorialStep;
use App\Models\TutorialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorialController extends Controller
{
    /**
     * Method SHOW (Redirector)
     * Fungsinya: Saat user buka /tutorial/1, otomatis cari step pertama
     */
    public function show($tutorialId)
    {
        $firstStep = TutorialStep::where('tutorial_id', $tutorialId)
                        ->orderBy('step_number', 'asc')
                        ->first();

        if ($firstStep) {
            return redirect()->route('tutorial.step', $firstStep->step_id);
        }

        return abort(404, 'Tutorial ini belum memiliki materi.');
    }

    /**
     * Menampilkan Daftar Semua Tutorial
     */
    public function index()
    {
        $user = Auth::user(); // <--- TAMBAHKAN INI
        
        $tutorials = Tutorial::with('course')->get();
        
        // Kirim $user ke view index
        return view('tutorials.index', compact('tutorials', 'user'));
    }

    /**
     * Method SHOW STEP
     * Menampilkan halaman coding & soal
     */
    public function showStep($stepId)
    {
        $user = Auth::user(); // <--- TAMBAHKAN INI

        // 1. Ambil data step saat ini (load tutorial & course untuk header)
        $step = TutorialStep::with('tutorial.course')->findOrFail($stepId);

        // 2. Ambil Tutorial ID
        $tutorialId = $step->tutorial_id;

        // 3. Hitung total langkah
        $totalSteps = TutorialStep::where('tutorial_id', $tutorialId)->count();

        // 4. Cari Step Selanjutnya (Next)
        $nextStep = TutorialStep::where('tutorial_id', $tutorialId)
                        ->where('step_number', '>', $step->step_number)
                        ->orderBy('step_number', 'asc')
                        ->first();

        // 5. Cari Step Sebelumnya (Previous)
        $prevStep = TutorialStep::where('tutorial_id', $tutorialId)
                        ->where('step_number', '<', $step->step_number)
                        ->orderBy('step_number', 'desc')
                        ->first();

        // 6. Cek progress user
        $progress = TutorialProgress::where('user_id', $user->user_id)
            ->where('step_id', $stepId)
            ->first();

        // PENTING: Tambahkan 'user' ke compact
        return view('tutorials.show', compact('step', 'progress', 'totalSteps', 'nextStep', 'prevStep', 'user'));
    }

    /**
     * Method SUBMIT CODE
     */
    public function submitCode(Request $request, $stepId)
    {
        $request->validate([
            'user_code' => 'required'
        ]);

        $step = TutorialStep::findOrFail($stepId);

        // Bersihkan kode dari spasi/enter berlebih
        $cleanUserCode = str_replace(["\r", "\n", " "], '', $request->user_code);
        $cleanSolution = str_replace(["\r", "\n", " "], '', $step->solution_code);

        $isCorrect = $cleanUserCode === $cleanSolution;

        // Simpan Progress
        TutorialProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'step_id' => $stepId
            ],
            [
                'user_code' => $request->user_code,
                'is_completed' => $isCorrect,
                'completed_at' => $isCorrect ? now() : null
            ]
        );

        if ($isCorrect) {
            return redirect()->back()->with('success', 'Selamat! Kode kamu benar. Silakan lanjut.');
        } else {
            return redirect()->back()->with('error', 'Kode belum tepat. Coba perhatikan petunjuk lagi.')->withInput();
        }
    }
}