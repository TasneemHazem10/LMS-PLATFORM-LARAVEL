<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Courses - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('components.header')
    
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold mb-8">My Courses</h1>
            
            @if($enrollments->count() > 0)
            <div class="space-y-4">
                @foreach($enrollments as $enrollment)
                <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col md:flex-row gap-6">
                    <img src="{{ $enrollment->course->thumbnail ? asset('storage/' . $enrollment->course->thumbnail) : 'https://via.placeholder.com/300x150' }}" alt="{{ $enrollment->course->title }}" class="w-full md:w-48 h-32 object-cover rounded-lg">
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold">{{ $enrollment->course->title }}</h3>
                            <span class="px-3 py-1 rounded-full text-sm {{ $enrollment->is_completed ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                {{ $enrollment->is_completed ? 'Completed' : 'In Progress' }}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4">{{ Str::limit($enrollment->course->description, 150) }}</p>
                        <div class="mb-3">
                            <div class="flex justify-between text-sm mb-1">
                                <span>Progress</span>
                                <span class="font-medium">{{ $enrollment->progress }}%</span>
                            </div>
<div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('course.learn', $enrollment->course) }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Continue Learning</a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl p-12 text-center">
                <p class="text-gray-500 text-lg mb-4">You haven't enrolled in any courses yet.</p>
                <a href="{{ route('courses.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">Browse Courses</a>
            </div>
            @endif
        </div>
    </main>
    
    @include('components.footer')
</body>
</html>
