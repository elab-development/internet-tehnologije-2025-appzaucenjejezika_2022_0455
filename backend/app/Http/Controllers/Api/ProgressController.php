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
     * Get user's progress + chart data
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $completedLessons = Progress::where('user_id', $user->id)
            ->where('completed', true)
            ->distinct('lesson_id')
            ->count('lesson_id');

        $totalLessons = Lesson::count();

        $totalPoints = Progress::where('user_id', $user->id)->sum('score');

        $courses = Course::all();

        $chart = $courses->map(function ($course) use ($user) {
            $lessonIds = Lesson::where('course_id', $course->id)->pluck('id');

            $totalCourseLessons = $lessonIds->count();

            $completedCourseLessons = 0;

            if ($totalCourseLessons > 0) {
                $completedCourseLessons = Progress::where('user_id', $user->id)
                    ->where('completed', true)
                    ->whereIn('lesson_id', $lessonIds)
                    ->distinct('lesson_id')
                    ->count('lesson_id');
            }

            $progress = $totalCourseLessons > 0
                ? round(($completedCourseLessons / $totalCourseLessons) * 100)
                : 0;

            return [
                'course' => $course->title,
                'progress' => $progress,
            ];
        })->values();

        return response()->json([
            'completed_lessons' => $completedLessons,
            'total_lessons'     => $totalLessons,
            'total_points'      => (int) $totalPoints,
            'current_streak'    => 0,
            'chart'             => $chart,
        ]);
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