<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses - LMS Platform</title>
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
                <h1 class="text-3xl font-bold">Courses</h1>
                <a href="{{ route('admin.courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Add Course</a>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4">Title</th>
                            <th class="text-left py-3 px-4">Category</th>
                            <th class="text-left py-3 px-4">Price</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $course->title }}</td>
                            <td class="py-3 px-4">{{ $course->category->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'Free' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs {{ $course->status === 'published' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                    {{ $course->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.courses.show', $course) }}" class="text-indigo-600 hover:underline mr-3">View</a>
                                <a href="{{ route('admin.courses.edit', $course) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
                                <a href="{{ route('admin.courses.lessons', $course) }}" class="text-indigo-600 hover:underline mr-3">Lessons</a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-4 text-center text-gray-500">No courses yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $courses->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html>
