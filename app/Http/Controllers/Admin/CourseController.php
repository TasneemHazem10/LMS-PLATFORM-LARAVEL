<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('category', 'creator');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        $courses = $query->latest()->paginate(15);
        $categories = Category::all();
        
        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        
        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load('lessons', 'category', 'creator', 'enrollments');
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        
        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
