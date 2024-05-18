<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function manageUsers()
    {
        $users = User::with('roles')->get();

        return view('backend.users', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,assistant',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Assign role based on the 'role' field in the form
        $user->assignRole($validatedData['role']);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function deleteRoles($userId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach(); // Remove all roles

        return redirect()->back()->with('success', 'Roles deleted successfully');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $user->password = bcrypt('nicolospass');
        $user->save();

        return redirect()->back()->with('success', 'Password reset successfully.');
    }

}
