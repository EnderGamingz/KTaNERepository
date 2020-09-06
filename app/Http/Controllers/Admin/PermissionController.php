<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Permission;
use App\Role;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        // Checks if the user has the right permissions
        if(!$request->user()->hasPermission('view.admin.permissions')) {
            abort(402);
            return;
        }

        // Fetching roles and permissions from the database
        // NOTE: This should not be fetch from cache,
        // because the administrator should allways see all data
        $permissions = Permission::all();
        $roles = Role::all();

        return view('admin.permissions.index', ['roles' => $roles, 'permissions' => $permissions]);
    }


}
