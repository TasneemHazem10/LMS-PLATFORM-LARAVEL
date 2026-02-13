<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/my-courses', [EnrollmentController::class, 'myCourses'])->name('my-courses');
    Route::post('/enroll/{course}', [EnrollmentController::class, 'enroll'])->name('enroll');
    Route::post('/lesson/{lesson}/complete', [LessonController::class, 'markComplete'])->name('lesson.complete');
    Route::get('/course/{course}/learn', [LessonController::class, 'learn'])->name('course.learn');
    Route::get('/lesson/{lesson}', [LessonController::class, 'show'])->name('lesson.show');
    Route::post('/lesson/{lesson}/quiz', [LessonController::class, 'submitQuiz'])->name('lesson.quiz');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('courses', AdminCourseController::class);
    Route::get('/courses/{course}/lessons', [AdminLessonController::class, 'index'])->name('courses.lessons');
    Route::resource('lessons', AdminLessonController::class);
    Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments');
});

require __DIR__.'/auth.php';
