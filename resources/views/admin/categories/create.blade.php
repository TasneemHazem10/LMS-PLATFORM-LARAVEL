<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($category) ? 'Edit' : 'Create' }} Category - LMS Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('components.header')
    <div class="flex">
        <aside class="w-64 bg-white shadow-sm min-h-screen">
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Users</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded-lg bg-indigo-100 text-indigo-600">Categories</a>
                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Courses</a>
                <a href="{{ route('admin.enrollments') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Enrollments</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">{{ isset($category) ? 'Edit' : 'Create' }} Category</h1>
            
            <div class="bg-white rounded-xl shadow-sm p-6 max-w-2xl">
                <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
                    @csrf
                    @if(isset($category)) @method('PUT') @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Name</label>
                        <input type="text" name="name" value="{{ isset($category) ? $category->name : '' }}" class="w-full px-4 py-2 border rounded-lg" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg">{{ isset($category) ? $category->description : '' }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Icon</label>
                        <input type="text" name="icon" value="{{ isset($category) ? $category->icon : '' }}" class="w-full px-4 py-2 border rounded-lg" placeholder="Icon class or emoji">
                    </div>
                    
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">{{ isset($category) ? 'Update' : 'Create' }}</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
