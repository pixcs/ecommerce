<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\User;

class UserController extends Controller
{
    public function getUsers() 
    {
        $usersWithRole = User::with('roles')->get();
        return response()->json($usersWithRole);
    }

    public function show(Request $request) {

        $user = User::with('roles')->find($request->id);

        return response()->json($user);
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'add_name' => 'required|string|max:255',
            'add_email' => 'required|string',
            'password' => 'required|string|min:8',
            'add_phone_number' => 'required|numeric',
            'add_address' => 'required|string',
            'add_e_wallet' => 'nullable|numeric',
            'add_roles' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated['add_name'],
            'email' => $validated['add_email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['add_phone_number'],
            'complete_address' => $validated['add_address'],
            'e_wallet' => $validated['add_e_wallet']
        ]);

        $user->attachRole($request->add_roles);

        $users = User::with('roles')->get();

       return response()->json($users);
    }

    public function update(Request $request) 
    {
        $validated = $request->validate([
            'manage_name' => 'required|string|max:255',
            'manage_email' => 'required|string',
            'manage_phone_number' => 'required',
            'manage_address' => 'required|string',
            'roles' => 'required|string',
            'status' => 'required|string',
        ]);

        $user = User::with('roles')->find($request->id);
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->name = $validated['manage_name'];
        $user->email = $validated['manage_email'];
        $user->phone_number = $validated['manage_phone_number'];
        $user->complete_address = $validated['manage_address'];
        $user->status = $validated['status'];

        $user->roles()->detach();

        $role = Role::where('name', $validated['roles'])->first();

        if ($role) {
            $user->roles()->attach($role);
        }

        $user->save();
        
        $users = User::with('roles')->get();
        
        return response()->json($users);
    }
}
