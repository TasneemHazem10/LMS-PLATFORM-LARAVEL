<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    public function myCourses()
    {
        $enrollments = Enrollment::where('user_id', auth()->id())
            ->with('course.category')
            ->latest()
            ->get();
            
        return view('student.my-courses', compact('enrollments'));
    }

    public function enroll(Course $course)
    {
        $user = auth()->user();
        
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();
            
        if ($existingEnrollment) {
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }
        
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'progress' => 0,
            'is_completed' => false,
        ]);
        
        return redirect()->route('course.learn', $course)->with('success', 'Successfully enrolled in the course!');
    }
}
