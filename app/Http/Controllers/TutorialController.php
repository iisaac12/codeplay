<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\TutorialStep;
use App\Models\TutorialProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorialController extends Controller
{
    // Tampilkan tutorial
    public function show($tutorialId)
    {
        $tutorial = Tutorial::with(['steps', 'course'])->findOrFail($tutorialId);
        
        return view('tutorials.show', compact('tutorial'));
    }

    // Tampilkan step tutorial
    public function showStep($stepId)
    {
        $step = TutorialStep::with('tutorial')->findOrFail($stepId);

        // Get user progress
        $progress = TutorialProgress::where('user_id', Auth::id())
            ->where('step_id', $stepId)
            ->first();

        return view('tutorials.step', compact('step', 'progress'));
    }

    // Submit kode tutorial
    public function submitCode(Request $request, $stepId)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $step = TutorialStep::findOrFail($stepId);

        // TODO: Validasi kode dengan solution_code
        $isCorrect = trim($request->code) === trim($step->solution_code);

        // Save progress
        $progress = TutorialProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'step_id' => $stepId
            ],
            [
                'user_code' => $request->code,
                'is_completed' => $isCorrect,
                'completed_at' => $isCorrect ? now() : null
            ]
        );

        return response()->json([
            'success' => $isCorrect,
            'message' => $isCorrect ? 'Kode benar! Lanjut ke step berikutnya.' : 'Kode belum tepat, coba lagi!'
        ]);
    }
}
