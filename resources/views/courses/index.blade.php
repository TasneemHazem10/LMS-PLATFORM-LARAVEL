<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Courses - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col transition-colors duration-300">
    @include('components.header')
    
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">All Courses</h1>
                <p class="text-gray-400">Explore our comprehensive course catalog</p>
            </div>
            
            <!-- Filters -->
            <div class="card p-6 mb-8">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses..." class="input-field">
                    </div>
                    <select name="category" class="input-field max-w-[200px]">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>
                </form>
            </div>
            
            <!-- Courses Grid -->
            @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($courses as $course)
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
                            <span class="text-sm text-gray-500">{{ $course->lessons_count ?? 0 }} lessons</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            
            <div class="mt-10">
                {{ $courses->links() }}
            </div>
            @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-800 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-400 text-xl mb-4">No courses found matching your criteria.</p>
                <a href="{{ route('courses.index') }}" class="link">Clear filters</a>
            </div>
            @endif
        </div>
    </main>
    
    @include('components.footer')
</body>
</html>
