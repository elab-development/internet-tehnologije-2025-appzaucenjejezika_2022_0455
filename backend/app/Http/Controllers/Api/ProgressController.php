<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Get user's progress (for progress chart)
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Uzmi sve kurseve sa njihovim lekcijama
        $courses = Course::with('lessons')->get();

        $data = $courses->map(function ($course) use ($user) {

            $lessonIds = $course->lessons->pluck('id');

            $totalLessons = $lessonIds->count();

            $completedLessons = Progress::where('user_id', $user->id)
                ->where('completed', true)
                ->whereIn('lesson_id', $lessonIds)
                ->distinct('lesson_id')
                ->count('lesson_id');

            $progress = $totalLessons > 0
                ? round(($completedLessons / $totalLessons) * 100)
                : 0;

            return [
                'course' => $course->title,
                'progress' => $progress,
            ];
        });

        return response()->json($data->values());
    }

    /**
     * Save or update lesson progress
     */
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

        return response()->json([
            'message' => 'Progress saved',
            'progress' => $progress
        ]);
    }
}