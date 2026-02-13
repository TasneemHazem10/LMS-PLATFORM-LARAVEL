<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses = Course::published()
            ->featured()
            ->with('category')
            ->take(6)
            ->get();
            
        $categories = Category::withCount('courses')->take(8)->get();
        
        return view('home', compact('featuredCourses', 'categories'));
    }

    public function dashboard()
    {
        $user = auth()->user();
        $enrollments = Enrollment::where('user_id', $user->id)
            ->with('course')
            ->latest()
            ->take(5)
            ->get();
            
        $completedCourses = $enrollments->where('is_completed', true)->count();
        $inProgressCourses = $enrollments->where('is_completed', false)->count();
        
        return view('student.dashboard', compact('enrollments', 'completedCourses', 'inProgressCourses'));
    }
}
