<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@lms.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);

        $categories = [
            ['name' => 'Programming', 'description' => 'Learn various programming languages and frameworks', 'icon' => '💻'],
            ['name' => 'Business', 'description' => 'Business and entrepreneurship courses', 'icon' => '💼'],
            ['name' => 'Design', 'description' => 'Graphic design, UI/UX, and creative courses', 'icon' => '🎨'],
            ['name' => 'Marketing', 'description' => 'Digital marketing and SEO courses', 'icon' => '📈'],
            ['name' => 'Data Science', 'description' => 'Data analysis, ML, and AI courses', 'icon' => '📊'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $course1 = Course::create([
            'title' => 'Complete Web Development Bootcamp',
            'description' => 'Learn HTML, CSS, JavaScript, PHP, and Laravel from scratch. Build real-world projects and become a full-stack developer.',
            'category_id' => 1,
            'created_by' => $admin->id,
            'price' => 0,
            'status' => 'published',
            'is_featured' => true,
        ]);

        $course2 = Course::create([
            'title' => 'Digital Marketing Masterclass',
            'description' => 'Master digital marketing strategies, SEO, social media marketing, and content marketing.',
            'category_id' => 4,
            'created_by' => $admin->id,
            'price' => 49.99,
            'status' => 'published',
            'is_featured' => true,
        ]);

        $course3 = Course::create([
            'title' => 'UI/UX Design Fundamentals',
            'description' => 'Learn the principles of user interface and user experience design using Figma and Adobe XD.',
            'category_id' => 3,
            'created_by' => $admin->id,
            'price' => 0,
            'status' => 'published',
            'is_featured' => false,
        ]);

        $lessons = [
            ['course_id' => $course1->id, 'title' => 'Introduction to Web Development', 'content_text' => 'Welcome to the course! In this lesson, we will cover the basics of web development.', 'duration' => 10, 'lesson_order' => 1],
            ['course_id' => $course1->id, 'title' => 'HTML Fundamentals', 'content_text' => 'Learn the building blocks of web pages with HTML.', 'duration' => 20, 'lesson_order' => 2],
            ['course_id' => $course1->id, 'title' => 'CSS Styling', 'content_text' => 'Make your websites beautiful with CSS.', 'duration' => 25, 'lesson_order' => 3],
            ['course_id' => $course1->id, 'title' => 'JavaScript Basics', 'content_text' => 'Add interactivity to your websites with JavaScript.', 'duration' => 30, 'lesson_order' => 4],
            ['course_id' => $course1->id, 'title' => 'PHP Introduction', 'content_text' => 'Server-side programming with PHP.', 'duration' => 25, 'lesson_order' => 5],
        ];

        foreach ($lessons as $lesson) {
            $createdLesson = Lesson::create($lesson);
            
            Quiz::create([
                'lesson_id' => $createdLesson->id,
                'question' => 'What is the purpose of ' . substr($lesson['title'], 0, 10) . '?',
                'option_a' => 'To style websites',
                'option_b' => 'To add interactivity',
                'option_c' => 'To structure content',
                'option_d' => 'To handle database',
                'correct_answer' => 'c',
            ]);
        }

        foreach ([$course2, $course3] as $course) {
            Lesson::create([
                'course_id' => $course->id,
                'title' => 'Introduction to ' . $course->title,
                'content_text' => 'Welcome to this course!',
                'duration' => 10,
                'lesson_order' => 1,
            ]);
        }
    }
}
