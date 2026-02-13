<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\Quiz;
use App\Models\QuizResult;

class LessonController extends Controller
{
    public function learn(Course $course)
    {
        $userId = auth()->id();
        
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();
            
        if (!$enrollment) {
            return redirect()->route('courses.show', $course)->with('error', 'Please enroll first.');
        }
        
        $lessons = $course->lessons()->orderBy('lesson_order')->get();
        
        $completedLessons = LessonProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();
        
        return view('student.learn', compact('course', 'lessons', 'enrollment', 'completedLessons'));
    }

    public function show(Lesson $lesson)
    {
        $userId = auth()->id();
        
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $lesson->course_id)
            ->first();
            
        if (!$enrollment) {
            return redirect()->route('courses.show', $lesson->course)->with('error', 'Please enroll first.');
        }
        
        $lessonProgress = LessonProgress::where('user_id', $userId)
            ->where('lesson_id', $lesson->id)
            ->first();
            
        $quiz = $lesson->quizzes()->first();
        
        return view('student.lesson', compact('lesson', 'enrollment', 'lessonProgress', 'quiz'));
    }

    public function markComplete(Lesson $lesson)
    {
        $userId = auth()->id();
        
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $lesson->course_id)
            ->first();
            
        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }
        
        LessonProgress::updateOrCreate(
            ['user_id' => $userId, 'lesson_id' => $lesson->id],
            ['is_completed' => true, 'watched_at' => now()]
        );
        
        $enrollment->updateProgress();
        
        return response()->json(['success' => true]);
    }

    public function submitQuiz(Request $request, Lesson $lesson)
    {
        $userId = auth()->id();
        
        $request->validate([
            'answer' => 'required|in:a,b,c,d',
            'quiz_id' => 'required|exists:quizzes,id'
        ]);
        
        $quiz = Quiz::findOrFail($request->quiz_id);
        
        $isCorrect = $quiz->correct_answer === $request->answer;
        
        QuizResult::create([
            'user_id' => $userId,
            'quiz_id' => $quiz->id,
            'selected_answer' => $request->answer,
            'is_correct' => $isCorrect,
        ]);
        
        return response()->json([
            'correct' => $isCorrect,
            'correct_answer' => $quiz->correct_answer
        ]);
    }
}
