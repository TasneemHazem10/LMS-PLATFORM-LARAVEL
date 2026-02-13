<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lessons - {{ $course->title }} - LMS Platform</title>
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
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold">Lessons</h1>
                    <p class="text-gray-600">{{ $course->title }}</p>
                </div>
                <a href="{{ route('admin.courses.lessons.create', $course) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Add Lesson</a>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4">Order</th>
                            <th class="text-left py-3 px-4">Title</th>
                            <th class="text-left py-3 px-4">Duration</th>
                            <th class="text-left py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lessons as $lesson)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $lesson->lesson_order }}</td>
                            <td class="py-3 px-4">{{ $lesson->title }}</td>
                            <td class="py-3 px-4">{{ $lesson->duration }} min</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.lessons.edit', $lesson) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-4 text-center text-gray-500">No lessons yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
