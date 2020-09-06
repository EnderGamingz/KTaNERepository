<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Permission;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Lists all users
     * @param request The alredy validated an authorized request
     */
    public function index(UserRequest $request)
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }
    
    /**
     * Shows the details of the given user
     * @param user The user to show
     * @param request The already validated an authorized request
     */
    public function show(User $user, UserRequest $request)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Updates the permissions of the given user
     * @param user The user to update
     * @param request The already validated an authorized request
     */
    public function permissions(User $user, UserRequest $request)
    {
        // Checks if role data is avaiblable
        if($request->roles) {
            // Fetch all roles based on the sent data
            $roles = Role::whereIn('id', $request->roles)->get();
            // Sync fetched roles with user
            $user->roles()->sync($roles);
        } else {
            $user->roles()->delete();
        }

        // Checks if permission data is available
        if($request->permissions) {
            // Fetch all permissions based on the sent data
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            // Sync fetched permissions with user
            $user->permissions()->sync($permissions);
        } else {
            $user->permissions()->delete();
        }

        return redirect()->route('admin.users.show', $user);
    }
}
