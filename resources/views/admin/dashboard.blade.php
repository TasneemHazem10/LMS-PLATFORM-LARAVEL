<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar { min-height: calc(100vh - 64px); }
    </style>
</head>
<body class="bg-gray-100">
    @include('components.header')
    
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm min-h-screen">
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-gray-50' }}">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-gray-50' }}">Users</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-gray-50' }}">Categories</a>
                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.courses.*') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-gray-50' }}">Courses</a>
                <a href="{{ route('admin.enrollments') }}" class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.enrollments') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-gray-50' }}">Enrollments</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
            
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-3xl font-bold text-indigo-600">{{ $stats['totalUsers'] }}</div>
                    <div class="text-gray-600">Total Users</div>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['totalStudents'] }}</div>
                    <div class="text-gray-600">Students</div>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['totalCourses'] }}</div>
                    <div class="text-gray-600">Courses</div>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['totalEnrollments'] }}</div>
                    <div class="text-gray-600">Enrollments</div>
                </div>
            </div>
            
            <!-- Recent Enrollments -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Recent Enrollments</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Student</th>
                                <th class="text-left py-3 px-4">Course</th>
                                <th class="text-left py-3 px-4">Date</th>
                                <th class="text-left py-3 px-4">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnrollments as $enrollment)
                            <tr class="border-b">
                                <td class="py-3 px-4">{{ $enrollment->user->name }}</td>
                                <td class="py-3 px-4">{{ $enrollment->course->title }}</td>
                                <td class="py-3 px-4">{{ $enrollment->enrolled_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4">{{ $enrollment->progress }}%</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-4 text-center text-gray-500">No enrollments yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Recent Courses -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-4">Recent Courses</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Title</th>
                                <th class="text-left py-3 px-4">Category</th>
                                <th class="text-left py-3 px-4">Status</th>
                                <th class="text-left py-3 px-4">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCourses as $course)
                            <tr class="border-b">
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.courses.show', $course) }}" class="text-indigo-600 hover:underline">{{ $course->title }}</a>
                                </td>
                                <td class="py-3 px-4">{{ $course->category->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $course->status === 'published' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        {{ $course->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">{{ $course->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-4 text-center text-gray-500">No courses yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
