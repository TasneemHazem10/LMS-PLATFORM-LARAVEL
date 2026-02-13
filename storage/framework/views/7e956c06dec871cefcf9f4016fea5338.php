<footer class="bg-gray-800 text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">LMS Platform</h3>
                <p class="text-gray-400">Your gateway to quality education. Learn at your own pace, anywhere, anytime.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="<?php echo e(route('home')); ?>" class="hover:text-white">Home</a></li>
                    <li><a href="<?php echo e(route('courses.index')); ?>" class="hover:text-white">Courses</a></li>
                    <li><a href="<?php echo e(route('login')); ?>" class="hover:text-white">Login</a></li>
                    <li><a href="<?php echo e(route('register')); ?>" class="hover:text-white">Register</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Categories</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="<?php echo e(route('courses.index')); ?>" class="hover:text-white">Programming</a></li>
                    <li><a href="<?php echo e(route('courses.index')); ?>" class="hover:text-white">Business</a></li>
                    <li><a href="<?php echo e(route('courses.index')); ?>" class="hover:text-white">Design</a></li>
                    <li><a href="<?php echo e(route('courses.index')); ?>" class="hover:text-white">Marketing</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Email: info@lmsplatform.com</li>
                    <li>Phone: +1 234 567 890</li>
                    <li>Address: 123 Learning St</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; <?php echo e(date('Y')); ?> LMS Platform. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php /**PATH C:\xampp\htdocs\LMS-Platform-laravel\resources\views/components/footer.blade.php ENDPATH**/ ?>