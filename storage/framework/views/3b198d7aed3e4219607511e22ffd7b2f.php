<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'LMS Platform')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        :root { --primary: #4F46E5; --primary-dark: #4338CA; --secondary: #10B981; }
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Welcome to LMS Platform</h1>
                <p class="text-xl mb-8">Your gateway to quality education. Learn from the best instructors.</p>
                <div class="flex justify-center gap-4">
                    <a href="<?php echo e(route('courses.index')); ?>" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">Browse Courses</a>
                    <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('register')); ?>" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600">Get Started</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div><div class="text-3xl font-bold text-indigo-600">50+</div><div class="text-gray-600">Courses</div></div>
                    <div><div class="text-3xl font-bold text-indigo-600">1000+</div><div class="text-gray-600">Students</div></div>
                    <div><div class="text-3xl font-bold text-indigo-600">20+</div><div class="text-gray-600">Instructors</div></div>
                    <div><div class="text-3xl font-bold text-indigo-600">100+</div><div class="text-gray-600">Lessons</div></div>
                </div>
            </div>
        </section>

        <!-- Featured Courses -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Featured Courses</h2>
                <?php if($featuredCourses->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php $__currentLoopData = $featuredCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                        <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x200'); ?>" alt="<?php echo e($course->title); ?>" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="text-sm text-indigo-600 mb-2"><?php echo e($course->category->name ?? 'Uncategorized'); ?></div>
                            <h3 class="text-lg font-semibold mb-2"><?php echo e($course->title); ?></h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(Str::limit($course->description, 100)); ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-600"><?php echo e($course->price > 0 ? '$' . number_format($course->price, 2) : 'Free'); ?></span>
                                <a href="<?php echo e(route('courses.show', $course)); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center text-gray-500 py-12"><p>No courses available yet. Check back soon!</p></div>
                <?php endif; ?>
                <div class="text-center mt-8">
                    <a href="<?php echo e(route('courses.index')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">View All Courses</a>
                </div>
            </div>
        </section>

        <!-- Categories -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Browse Categories</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('courses.index', ['category' => $category->id])); ?>" class="bg-gray-50 rounded-xl p-6 text-center hover:bg-indigo-50 transition">
                        <div class="text-3xl mb-2">📚</div>
                        <h3 class="font-semibold"><?php echo e($category->name); ?></h3>
                        <p class="text-sm text-gray-500"><?php echo e($category->courses_count); ?> courses</p>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-4 text-center text-gray-500">No categories yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-indigo-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold mb-4">Ready to Start Learning?</h2>
                <p class="text-xl mb-8">Join thousands of students already learning on our platform.</p>
                <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('register')); ?>" class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">Sign Up Now - It's Free!</a>
                <?php else: ?>
                <a href="<?php echo e(route('courses.index')); ?>" class="inline-block bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">Start Learning Now</a>
                <?php endif; ?>
            </div>
        </section>
    </main>
    
    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LMS-Platform-laravel\resources\views/home.blade.php ENDPATH**/ ?>