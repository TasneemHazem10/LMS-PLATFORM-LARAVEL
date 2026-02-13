<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::published()->with('category', 'creator');
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $courses = $query->latest()->paginate(12);
        $categories = Category::all();
        
        return view('courses.index', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }
        
        $course->load('category', 'creator', 'lessons');
        
        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = Enrollment::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->exists();
        }
        
        return view('courses.show', compact('course', 'isEnrolled'));
    }
}
