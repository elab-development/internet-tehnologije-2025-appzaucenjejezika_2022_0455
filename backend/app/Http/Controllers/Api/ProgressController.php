<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\Models\Lesson;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Get user's progress
     */
    public function index(Request $request)
{
    $user = $request->user();

    $completedLessons = Progress::where('user_id', $user->id)
                                ->where('completed', true)
                                ->distinct('lesson_id')
                                ->count('lesson_id');

    $totalLessons = \App\Models\Lesson::count();

    $totalPoints = Progress::where('user_id', $user->id)->sum('score');

    return response()->json([
        'completed_lessons' => $completedLessons,
        'total_lessons'     => $totalLessons,
        'total_points'      => (int) $totalPoints,
        'current_streak'    => 0,
    ]);
}
public function store(Request $request)
{
    $validated = $request->validate([
        'lesson_id' => 'required|exists:lessons,id',
        'score'     => 'required|integer|min:0',
        'completed' => 'boolean',
    ]);

    $progress = Progress::updateOrCreate(
        [
            'user_id'   => $request->user()->id,
            'lesson_id' => $validated['lesson_id'],
        ],
        [
            'score'     => $validated['score'],
            'completed' => $validated['completed'] ?? false,
        ]
    );

    return response()->json(['message' => 'Progress saved', 'progress' => $progress]);
}
}