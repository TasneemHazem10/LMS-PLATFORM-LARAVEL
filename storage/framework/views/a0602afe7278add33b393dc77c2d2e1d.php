<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Courses - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold mb-8">All Courses</h1>
            
            <!-- Filters -->
            <div class="bg-white rounded-xl p-6 mb-8 shadow-sm">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search courses..." class="w-full px-4 py-2 border rounded-lg">
                    </div>
                    <select name="category" class="px-4 py-2 border rounded-lg">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Filter</button>
                </form>
            </div>
            
            <!-- Courses Grid -->
            <?php if($courses->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                    <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x200'); ?>" alt="<?php echo e($course->title); ?>" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="text-sm text-indigo-600 mb-2"><?php echo e($course->category->name ?? 'Uncategorized'); ?></div>
                        <h3 class="text-lg font-semibold mb-2"><?php echo e($course->title); ?></h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(Str::limit($course->description, 100)); ?></p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-indigo-600"><?php echo e($course->price > 0 ? '$' . number_format($course->price, 2) : 'Free'); ?></span>
                            <a href="<?php echo e(route('courses.show', $course)); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="mt-8">
                <?php echo e($courses->links()); ?>

            </div>
            <?php else: ?>
            <div class="text-center py-12 text-gray-500">
                <p class="text-xl">No courses found matching your criteria.</p>
                <a href="<?php echo e(route('courses.index')); ?>" class="text-indigo-600 hover:underline mt-2 inline-block">Clear filters</a>
            </div>
            <?php endif; ?>
        </div>
    </main>
    
    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\LMS-Platform-laravel\resources\views/courses/index.blade.php ENDPATH**/ ?>