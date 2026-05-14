<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['siswa', 'guru']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function resetPassword(User $user)
    {
        $defaultPassword = 'password123'; // atau generate random
        
        $user->update([
            'password' => Hash::make($defaultPassword),
        ]);

        return back()->with('success', "Password untuk {$user->name} berhasil direset ke: {$defaultPassword}");
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status == 'aktif' ? 'nonaktif' : 'aktif',
        ]);

        return back()->with('success', "Status {$user->name} diubah menjadi " . ucfirst($user->status));
    }
}