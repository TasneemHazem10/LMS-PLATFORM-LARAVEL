<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users - LMS Platform</title>
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
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded-lg bg-indigo-100 text-indigo-600">Users</a>
                <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Categories</a>
                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Courses</a>
                <a href="{{ route('admin.enrollments') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-50">Enrollments</a>
            </nav>
        </aside>
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">Manage Users</h1>
            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4">Name</th>
                            <th class="text-left py-3 px-4">Email</th>
                            <th class="text-left py-3 px-4">Role</th>
                            <th class="text-left py-3 px-4">Status</th>
                            <th class="text-left py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs {{ $user->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-indigo-600 hover:underline">{{ $user->status === 'active' ? 'Block' : 'Unblock' }}</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-4 text-center text-gray-500">No users found</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html>
