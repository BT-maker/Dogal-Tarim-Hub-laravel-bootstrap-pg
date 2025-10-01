<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::withCount('posts')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'is_active' => $request->boolean('is_active', true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla oluşturuldu!',
            'user' => $user
        ]);
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load(['posts' => function($query) {
            $query->latest()->take(10);
        }]);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active', true)
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla güncellendi!',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Check if user has posts
        if ($user->posts()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Bu kullanıcıya ait yazılar bulunduğu için silinemez!'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı başarıyla silindi!'
        ]);
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı durumu güncellendi!',
            'is_active' => $user->is_active
        ]);
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kullanıcı şifresi başarıyla sıfırlandı!'
        ]);
    }
}