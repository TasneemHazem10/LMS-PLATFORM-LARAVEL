<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enrollments - LMS Platform</title>
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
                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Courses</a>
                <a href="{{ route('admin.enrollments') }}" class="block px-4 py-2 rounded-lg bg-indigo-100 text-indigo-600">Enrollments</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">Enrollments</h1>
            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4">Student</th>
                            <th class="text-left py-3 px-4">Course</th>
                            <th class="text-left py-3 px-4">Progress</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Enrolled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $enrollment)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $enrollment->user->name }}</td>
                            <td class="py-3 px-4">{{ $enrollment->course->title }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
<div class="w-24 bg-gray-200 rounded-full h-2">
                                        <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                                    </div>
                                    <span>{{ $enrollment->progress }}%</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs {{ $enrollment->is_completed ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                    {{ $enrollment->is_completed ? 'Completed' : 'In Progress' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ $enrollment->enrolled_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-4 text-center text-gray-500">No enrollments yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $enrollments->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html>
