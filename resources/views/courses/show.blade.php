<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col transition-colors duration-300">
    @include('components.header')
    
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="relative h-72 rounded-2xl overflow-hidden mb-6">
                        <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=400&fit=crop' }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                    </div>
                    
                    <div class="flex items-center gap-3 mb-4">
                        <span class="badge badge-primary">{{ $course->category->name ?? 'General' }}</span>
                        <span class="text-gray-500">•</span>
                        <span class="text-gray-400">{{ $course->lessons->count() }} lessons</span>
                        <span class="text-gray-500">•</span>
                        <span class="badge {{ $course->status === 'published' ? 'badge-success' : '' }}">{{ $course->status }}</span>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-white mb-6">{{ $course->title }}</h1>
                    
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-white mb-3">About this course</h2>
                        <p class="text-gray-400 leading-relaxed">{{ $course->description }}</p>
                    </div>
                    
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-white mb-4">Course Content</h2>
                        <div class="card divide-y divide-gray-700 overflow-hidden">
                            @forelse($course->lessons as $index => $lesson)
                            <div class="p-4 flex items-center gap-4 hover:bg-gray-700/50 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-sm font-semibold">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-white">{{ $lesson->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $lesson->duration }} min</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                </svg>
                            </div>
                            @empty
                            <div class="p-8 text-center text-gray-500">No lessons yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-1">
                    <div class="card p-6 sticky top-24">
                        <div class="text-4xl font-bold text-white mb-2">{{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'Free' }}</div>
                        <p class="text-gray-500 mb-6">Full lifetime access</p>
                        
                        @auth
                            @if($isEnrolled)
                                <a href="{{ route('course.learn', $course) }}" class="block w-full bg-gradient-to-r from-green-500 to-emerald-500 text-white text-center py-4 rounded-xl font-semibold hover:from-green-600 hover:to-emerald-600 mb-4 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    </svg>
                                    Continue Learning
                                </a>
                            @else
                                <form action="{{ route('enroll', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-primary w-full justify-center py-4 text-lg">
                                        {{ $course->price > 0 ? 'Enroll Now' : 'Start Learning' }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-primary w-full justify-center py-4 text-lg">Login to Enroll</a>
                        @endauth
                        
                        <div class="border-t border-gray-700 pt-5 mt-5">
                            <h3 class="font-semibold text-white mb-4">This course includes:</h3>
                            <ul class="space-y-3 text-gray-400">
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ $course->lessons->count() }} lessons
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Full lifetime access
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Access on mobile and desktop
                                </li>
                                <li class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Certificate of completion
                                </li>
                            </ul>
                        </div>
                        
                        <div class="border-t border-gray-700 pt-5 mt-5">
                            <p class="text-sm text-gray-500">Created by <span class="font-medium text-white">{{ $course->creator->name ?? 'Admin' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    @include('components.footer')
</body>
</html>
