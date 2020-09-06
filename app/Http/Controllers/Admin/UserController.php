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
}
