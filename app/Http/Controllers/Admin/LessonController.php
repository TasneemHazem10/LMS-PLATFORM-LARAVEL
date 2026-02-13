<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Quiz;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons()->orderBy('lesson_order')->get();
        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_text' => 'nullable|string',
            'video_path' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:0',
            'lesson_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['course_id'] = $course->id;
        
        if (!$request->lesson_order) {
            $data['lesson_order'] = $course->lessons()->max('lesson_order') + 1;
        }
        
        Lesson::create($data);

        return redirect()->route('admin.courses.lessons', $course)->with('success', 'Lesson created successfully.');
    }

    public function edit(Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content_text' => 'nullable|string',
            'video_path' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:0',
            'lesson_order' => 'nullable|integer|min:0',
        ]);

        $lesson->update($request->all());

        return redirect()->route('admin.courses.lessons', $lesson->course)->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $course = $lesson->course;
        $lesson->delete();
        return redirect()->route('admin.courses.lessons', $course)->with('success', 'Lesson deleted successfully.');
    }
}
