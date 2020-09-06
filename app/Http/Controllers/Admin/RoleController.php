<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Role;
use App\Permission;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * Stores a new Role Object
     * @param request The already validated and checked request data
     */
    public function store(RoleRequest $request)
    {

        // Create a new role object
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // Check if the request has permissions
        if($request->permissions) {
            // Get all permissions
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            // Sync the fetched permissions with role
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.show', $role);
    }

    /**
     * Shows the given role object
     * @param role The role to show
     * @param request The already validated and authorized request
     */
    public function show(Role $role, RoleRequest $request)
    {
        if(!$request->user()->hasPermission('show.admin.roles')) {
            abort(402);
            return;
        }

        return view('admin.roles.show', ['role' => $role]);
    }

    /**
     * Updates the given role object
     * @param role The role to update
     * @param request The alredy validated and authorized request
     */
    public function update(Role $role, RoleRequest $request)
    {
        // Updating the infomration
        $role->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // Check if the request has permissions
        if($request->permissions) {
            // Get all permissions
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            // Sync the fetched permissions with role
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.show', $role);
    }
}
