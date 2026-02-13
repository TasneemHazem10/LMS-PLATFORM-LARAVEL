<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($lesson) ? 'Edit' : 'Create' }} Lesson - LMS Platform</title>
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
                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Courses</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">{{ isset($lesson) ? 'Edit' : 'Create' }} Lesson</h1>
            
            <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
                <form method="POST" action="{{ isset($lesson) ? route('admin.lessons.update', $lesson) : route('admin.lessons.store', $course) }}">
                    @csrf
                    @if(isset($lesson)) @method('PUT') @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Title</label>
                        <input type="text" name="title" value="{{ isset($lesson) ? $lesson->title : '' }}" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Content Text</label>
                        <textarea name="content_text" rows="6" class="w-full px-4 py-2 border rounded-lg">{{ isset($lesson) ? $lesson->content_text : '' }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Video Path</label>
                        <input type="text" name="video_path" value="{{ isset($lesson) ? $lesson->video_path : '' }}" class="w-full px-4 py-2 border rounded-lg" placeholder="Path to video file">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Duration (minutes)</label>
                        <input type="number" name="duration" value="{{ isset($lesson) ? $lesson->duration : 0 }}" class="w-full px-4 py-2 border rounded-lg" min="0">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Order</label>
                        <input type="number" name="lesson_order" value="{{ isset($lesson) ? $lesson->lesson_order : '' }}" class="w-full px-4 py-2 border rounded-lg" min="0">
                    </div>
                    
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">{{ isset($lesson) ? 'Update' : 'Create' }}</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
