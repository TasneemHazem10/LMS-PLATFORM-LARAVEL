<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-indigo-600">LMS</a>
                <nav class="hidden md:flex ml-10 space-x-8">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-indigo-600">Home</a>
                    <a href="<?php echo e(route('courses.index')); ?>" class="text-gray-700 hover:text-indigo-600">Courses</a>
                </nav>
            </div>
            
            <div class="flex items-center space-x-4">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-700 hover:text-indigo-600">Admin Panel</a>
                    <?php endif; ?>
                    <div class="relative">
                        <button id="userMenuBtn" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                            <span><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                            <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="<?php echo e(route('my-courses')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">My Courses</a>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-indigo-600">Login</a>
                    <a href="<?php echo e(route('register')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script>
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');
    if (userMenuBtn && userMenu) {
        userMenuBtn.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });
        document.addEventListener('click', (e) => {
            if (!userMenuBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }
</script>
<?php /**PATH C:\xampp\htdocs\LMS-Platform-laravel\resources\views/components/header.blade.php ENDPATH**/ ?>