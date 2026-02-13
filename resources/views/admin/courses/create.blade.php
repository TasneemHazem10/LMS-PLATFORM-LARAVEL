<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($course) ? 'Edit' : 'Create' }} Course - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.header')
    <div class="flex">
        <aside class="w-64 bg-white shadow-sm min-h-screen">
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Users</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Categories</a>
                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 rounded-lg bg-indigo-100 text-indigo-600">Courses</a>
                <a href="{{ route('admin.enrollments') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Enrollments</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">{{ isset($course) ? 'Edit' : 'Create' }} Course</h1>
            
            <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
                <form method="POST" action="{{ isset($course) ? route('admin.courses.update', $course) : route('admin.courses.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($course)) @method('PUT') @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Title</label>
                        <input type="text" name="title" value="{{ isset($course) ? $course->title : '' }}" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ isset($course) ? $course->description : '' }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Category</label>
                        <select name="category_id" class="w-full px-4 py-2 border rounded-lg" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ isset($course) && $course->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Price</label>
                        <input type="number" name="price" value="{{ isset($course) ? $course->price : 0 }}" class="w-full px-4 py-2 border rounded-lg" step="0.01" min="0">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Thumbnail</label>
                        <input type="file" name="thumbnail" class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border rounded-lg">
                            <option value="draft" {{ isset($course) && $course->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ isset($course) && $course->status == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ isset($course) && $course->is_featured ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm font-medium">Featured Course</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">{{ isset($course) ? 'Update' : 'Create' }}</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
