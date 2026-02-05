<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // INDEX - Tampilkan semua admin users
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'staff'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('pages.admin.settings.admin-users.index', compact('users'));
    }

    // CREATE - Form create
    public function create()
    {
        return view('pages.admin.settings.admin-users.create');
    }

    // STORE - Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,staff',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.settings.admin-users.index')
            ->with('success', 'Admin user created successfully.');
    }

    // EDIT - Form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.settings.admin-users.edit', compact('user'));
    }

    // UPDATE - Update data
   public function update(Request $request, $id)
{
    \Log::info('=== ADMIN USER UPDATE CALLED ===');
    \Log::info('User ID: ' . $id);
    \Log::info('Request Data: ', $request->all());
    \Log::info('Method: ' . $request->method());
    \Log::info('Full URL: ' . $request->fullUrl());
    
    $user = User::findOrFail($id);
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,staff',
        'status' => 'required|in:active,inactive',
        'password' => 'nullable|min:8|confirmed',
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => $request->role,
        'status' => $request->status,
    ];

    if ($request->password) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('admin.settings.admin-users.index')
        ->with('success', 'Admin user updated successfully.');
}
    // DESTROY - Hapus data
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Jangan hapus diri sendiri
        if ($user->id == auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.settings.admin-users.index')
            ->with('success', 'Admin user deleted successfully.');
    }
}