<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class PermissionsController extends Controller
{
    public function getPermissions()
    {
        $roles = Role::with('permissions')->get();

        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string',
            'description' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description']
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->attach($validated['permissions']);
        }
     
        $roles = Role::with('permissions')->get();

        return response()->json($roles);
    }

    public function show(Request $request) 
    {
        $role = Role::with('permissions')->find($request->id);

        return response()->json($role);
    }

    public function update(Request $request) 
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string',
            'description' => 'required|string',
            'edit_permissions' => 'nullable|array',
        ]);
        
        $role = Role::with('permissions')->findOrFail($request->id);

        $role->update([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'],
            'description' => $validated['description']
        ]);

        $role->permissions()->sync($validated['edit_permissions']);

        $roles = Role::with('permissions')->get();

        return response()->json($roles);
    }
}
