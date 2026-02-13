<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with('user', 'course');
        
        if ($request->course) {
            $query->where('course_id', $request->course);
        }
        
        $enrollments = $query->latest()->paginate(20);
        
        return view('admin.enrollments.index', compact('enrollments'));
    }
}
