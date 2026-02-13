<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LMS Platform') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col transition-colors duration-300">
    @include('components.header')
    
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="hero-gradient relative overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-500/20 rounded-full blur-3xl"></div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-sm mb-6">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        Start Learning Today
                    </div>
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        Master New Skills with<br>
                        <span class="gradient-text">Expert-Led Courses</span>
                    </h1>
                    <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">
                        Unlock your potential with our comprehensive learning platform. 
                        Access hundreds of courses taught by industry experts.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('courses.index') }}" class="btn-primary text-lg px-8 py-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Browse Courses
                        </a>
                        @guest
                        <a href="{{ route('register') }}" class="btn-secondary text-lg px-8 py-4 border-gray-600 hover:border-indigo-500">
                            Start Free Trial
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 border-b border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">{{ $featuredCourses->count() * 10 }}+</div>
                        <div class="text-gray-400">Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">500+</div>
                        <div class="text-gray-400">Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">50+</div>
                        <div class="text-gray-400">Instructors</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-white mb-2">1000+</div>
                        <div class="text-gray-400">Lessons</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Courses -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Featured Courses</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">Explore our most popular courses and start your learning journey today.</p>
                </div>
                
                @if($featuredCourses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredCourses as $course)
                    <a href="{{ route('courses.show', $course) }}" class="card group block overflow-hidden">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=200&fit=crop' }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                            <span class="absolute top-4 left-4 badge badge-primary">{{ $course->category->name ?? 'General' }}</span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white mb-2 group-hover:text-indigo-400 transition-colors">{{ $course->title }}</h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ Str::limit($course->description, 100) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-2xl font-bold text-indigo-400">{{ $course->price > 0 ? '$' . number_format($course->price, 2) : 'Free' }}</span>
                                <span class="text-sm text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $course->lessons_count ?? 0 }} lessons
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-800 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg">No courses available yet. Check back soon!</p>
                </div>
                @endif
                
                <div class="text-center mt-12">
                    <a href="{{ route('courses.index') }}" class="btn-secondary inline-flex items-center gap-2">
                        View All Courses
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Categories -->
        <section class="py-20 bg-gray-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Browse Categories</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">Find the perfect course in your area of interest.</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @forelse($categories as $category)
                    <a href="{{ route('courses.index', ['category' => $category->id]) }}" class="card p-6 text-center group">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-cyan-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-white mb-1">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->courses_count }} courses</p>
                    </a>
                    @empty
                    <div class="col-span-4 text-center text-gray-500 py-8">No categories yet.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/50 to-purple-900/50"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Start Learning?</h2>
                <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto">Join thousands of students already learning on our platform. Start your journey today.</p>
                @guest
                <a href="{{ route('register') }}" class="btn-primary text-lg px-10 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    Sign Up for Free
                </a>
                @else
                <a href="{{ route('courses.index') }}" class="btn-primary text-lg px-10 py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Start Learning Now
                </a>
                @endguest
            </div>
        </section>
    </main>
    
    @include('components.footer')
</body>
</html>
