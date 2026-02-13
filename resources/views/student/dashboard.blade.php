<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col transition-colors duration-300">
    @include('components.header')
    
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">My Dashboard</h1>
                <p class="text-gray-400">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="card p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-indigo-500/20 flex items-center justify-center">
                            <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white">{{ $enrollments->count() }}</div>
                            <div class="text-gray-400">Enrolled Courses</div>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-green-500/20 flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white">{{ $completedCourses }}</div>
                            <div class="text-gray-400">Completed</div>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                            <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white">{{ $inProgressCourses }}</div>
                            <div class="text-gray-400">In Progress</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2 class="text-xl font-semibold text-white mb-6">Continue Learning</h2>
            
            @if($enrollments->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($enrollments as $enrollment)
                <div class="card overflow-hidden">
                    <div class="relative h-40">
                        <img src="{{ $enrollment->course->thumbnail ? asset('storage/' . $enrollment->course->thumbnail) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=200&fit=crop' }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                        <span class="absolute top-3 left-3 badge {{ $enrollment->is_completed ? 'badge-success' : 'badge-primary' }}">
                            {{ $enrollment->is_completed ? 'Completed' : 'In Progress' }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-white mb-3">{{ $enrollment->course->title }}</h3>
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-400">Progress</span>
                                <span class="font-medium text-white">{{ $enrollment->progress }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-gradient-to-r from-indigo-500 to-cyan-400 h-2 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('course.learn', $enrollment->course) }}" class="btn-primary w-full justify-center">
                            {{ $enrollment->is_completed ? 'Review Course' : 'Continue Learning' }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="card p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-800 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-gray-400 text-lg mb-6">You haven't enrolled in any courses yet.</p>
                <a href="{{ route('courses.index') }}" class="btn-primary">Browse Courses</a>
            </div>
            @endif
        </div>
    </main>
    
    @include('components.footer')
</body>
</html>
