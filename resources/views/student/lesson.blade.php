<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $lesson->title }} - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    @include('components.header')
    
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <a href="{{ route('course.learn', $lesson->course) }}" class="text-indigo-600 hover:text-indigo-800">← Back to Course</a>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        @if($lesson->video_path)
                        <div class="aspect-video bg-black">
                            <video controls class="w-full h-full" controlsList="nodownload">
                                <source src="{{ asset('storage/' . $lesson->video_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        @endif
                        
                        <div class="p-6">
                            <h1 class="text-2xl font-bold mb-4">{{ $lesson->title }}</h1>
                            
                            @if($lesson->content_text)
                            <div class="prose max-w-none">
                                {!! nl2br(e($lesson->content_text)) !!}
                            </div>
                            @endif
                            
                            <div class="mt-6 pt-6 border-t">
                                <button id="markCompleteBtn" 
                                        data-lesson-id="{{ $lesson->id }}"
                                        class="px-6 py-3 rounded-lg font-semibold {{ $lessonProgress && $lessonProgress->is_completed ? 'bg-green-500 text-white' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                                    {{ $lessonProgress && $lessonProgress->is_completed ? '✓ Completed' : 'Mark as Complete' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    @if($quiz)
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4">Quiz</h3>
                        <p class="text-gray-600 mb-4">Test your knowledge with a quick quiz!</p>
                        
                        <div id="quizSection">
                            <p class="font-medium mb-2">{{ $quiz->question }}</p>
                            
                            <div class="space-y-2 mb-4">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="answer" value="a" class="mr-3">
                                    <span>{{ $quiz->option_a }}</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="answer" value="b" class="mr-3">
                                    <span>{{ $quiz->option_b }}</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="answer" value="c" class="mr-3">
                                    <span>{{ $quiz->option_c }}</span>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="answer" value="d" class="mr-3">
                                    <span>{{ $quiz->option_d }}</span>
                                </label>
                            </div>
                            
                            <button id="submitQuiz" data-quiz-id="{{ $quiz->id }}" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Submit Answer</button>
                            
                            <div id="quizResult" class="hidden mt-4 p-4 rounded-lg"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    
    @include('components.footer')
    
    <script>
        document.getElementById('markCompleteBtn')?.addEventListener('click', async function() {
            const lessonId = this.dataset.lessonId;
            const btn = this;
            
            try {
                const response = await fetch(`/lesson/${lessonId}/complete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                if (data.success) {
                    btn.textContent = '✓ Completed';
                    btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                    btn.classList.add('bg-green-500');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
        
        document.getElementById('submitQuiz')?.addEventListener('click', async function() {
            const quizId = this.dataset.quizId;
            const answer = document.querySelector('input[name="answer"]:checked');
            
            if (!answer) {
                alert('Please select an answer');
                return;
            }
            
            try {
                const response = await fetch(`/lesson/${quizId}/quiz`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 
                        quiz_id: quizId,
                        answer: answer.value 
                    })
                });
                
                const data = await response.json();
                const resultDiv = document.getElementById('quizResult');
                resultDiv.classList.remove('hidden');
                
                if (data.correct) {
                    resultDiv.className = 'mt-4 p-4 rounded-lg bg-green-100 text-green-700';
                    resultDiv.innerHTML = '✓ Correct! Well done!';
                } else {
                    resultDiv.className = 'mt-4 p-4 rounded-lg bg-red-100 text-red-700';
                    resultDiv.innerHTML = `✗ Incorrect. The correct answer is: ${data.correct_answer.toUpperCase()}`;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
</body>
</html>
