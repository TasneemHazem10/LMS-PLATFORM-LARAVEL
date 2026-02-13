<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Category;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalStudents' => User::where('role', 'student')->count(),
            'totalInstructors' => User::where('role', 'admin')->count(),
            'totalCourses' => Course::count(),
            'publishedCourses' => Course::where('status', 'published')->count(),
            'totalEnrollments' => Enrollment::count(),
            'totalCategories' => Category::count(),
        ];
        
        $recentEnrollments = Enrollment::with('user', 'course')
            ->latest()
            ->take(10)
            ->get();
            
        $recentCourses = Course::with('creator', 'category')
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'recentEnrollments', 'recentCourses'));
    }
}
