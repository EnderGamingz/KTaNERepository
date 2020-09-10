<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
class ModuleMaintainerController extends Controller
{
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

        $user = User::where('email', $email)->first();
        if(!$user) {
            return response()->json(['message' => 'No user found'], 404);
        }

        if($module->maintainer->contains('id', $user) || $module->publisher_id == $user->id) {
            return response()->json(['message' => 'User is already maintanier']);
        }

        $module->maintainer()->attach($user);

        return response()->json(['username' => $user->username], 202);
    }
}
