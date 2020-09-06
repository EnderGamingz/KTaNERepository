<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Permission;
use App\Role;
use Artisan;

class PermissionController extends Controller
{

    /**
     * Shows the index view of the permission manager
     * @param request HTTP Request
     */
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

    /**
     * Syncs up the permissions defined in the configuration file ('config/permission.php') using the 'permissions:init' command
     * @param request HTTP Request
     */
    public function sync(Request $request)
    {
        // Checks if the user has the right permissions
        if(!$request->user()->hasPermission('sync.admin.permissions')) {
            abort(402);
            return;
        }

        // Calling the 'permission:init' command
        Artisan::call('permission:init');
        // Collecting the output of the command
        $out = Artisan::output();

        // NOTE: There is no need to flush the cache, because the command already does it

        return redirect()->route('admin.permissions.index')->with(['syncComplete' => $out]);
    }


}
