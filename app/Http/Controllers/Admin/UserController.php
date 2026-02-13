<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->role) {
            $query->where('role', $request->role);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        $users = $query->latest()->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'blocked' : 'active';
        $user->update(['status' => $newStatus]);
        
        return redirect()->back()->with('success', 'User status updated successfully.');
    }
}
