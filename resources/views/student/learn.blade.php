<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learning: {{ $course->title }} - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('components.header')
    
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Dashboard</a>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar - Course Content -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h2 class="text-lg font-semibold mb-4">{{ $course->title }}</h2>
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span>Progress</span>
                                <span class="font-medium">{{ $enrollment->progress }}%</span>
                            </div>
<div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $enrollment->progress }}%"></div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            @foreach($lessons as $index => $lesson)
                            <a href="{{ route('lesson.show', $lesson) }}" 
                               class="block p-3 rounded-lg hover:bg-gray-50 {{ in_array($lesson->id, $completedLessons) ? 'bg-green-50' : '' }}">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs {{ in_array($lesson->id, $completedLessons) ? 'bg-green-500 text-white' : 'bg-gray-200' }}">
                                        @if(in_array($lesson->id, $completedLessons))
                                        ✓
                                        @else
                                        {{ $index + 1 }}
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">{{ $lesson->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $lesson->duration }} min</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <h2 class="text-2xl font-bold mb-4">Welcome to this Course!</h2>
                        <p class="text-gray-600 mb-6">Select a lesson from the sidebar to start learning.</p>
                        
                        @if($lessons->count() > 0)
                        <a href="{{ route('lesson.show', $lessons->first()) }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                            Start First Lesson
                        </a>
                        @else
                        <p class="text-gray-500">No lessons available yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    @include('components.footer')
</body>
</html>
