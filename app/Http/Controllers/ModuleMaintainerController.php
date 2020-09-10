<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use App\User;

class ModuleMaintainerController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        // Setting the auth middleware for this controller
        $this->middleware('auth');
    }

    public function store($module, Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            abort(404);
            return;
        }

        if(!$request->user()->can('update', $module)) {
            abort(402);
            return;
        }

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return response()->json(['message' => 'No user found'], 404);
        }

        if($module->maintainer->contains('id', $user) || $module->publisher_id == $user->id) {
            return response()->json(['message' => 'User is already maintainer of this module'], 403);
        }

        $module->maintainer()->attach($user);

        Cache::clear('modules');

        return response()->json(['username' => $user->username], 202);
    }

    public function destroy($module, $username, Request $request)
    {
        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            abort(404);
            return;
        }

        if(!$request->user()->can('update', $module)) {
            abort(402);
            return;
        }

        $maintainer = $module->maintainer->where('username', $username)->first();
        if(!$maintainer) {
            return response()->json(['message' => 'User is not maintainer of this module'], 403);
        }

        $module->maintainer()->detach($maintainer);

        Cache::clear('modules');

        return response()->json(['success' => true]);
    }
}
