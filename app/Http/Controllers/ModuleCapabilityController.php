<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\ModuleCapability;
use App\Http\Requests\ModuleCapabilityRequest;
use Cache;
use Auth;
class ModuleCapabilityController extends Controller
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

    /**
     * @param module The Module UID
     * @param request The NOT authenticated, but validated request
     */
    public function store($module, ModuleCapabilityRequest $request)
    {
        // Get the modules from cache using the provided uid
        $module = Cache::get('modules')->where('uid', $module)->first();
        // Check if the module has not been found
        if(!$module) {
            // Abort with statuscode 404
            abort(404);
            return;
        }

        // Check if the user has permission to update the module
        if(!Auth::check('update', $module)) {
            // Return 402 if the user is not permitted
            abort(402);
            return;
        }

        // Check if the module already has the capability
        if($module->capabilities->contains('name', $request->type)) {
            // Return 403 response code with the error message
            return response()->json(['message' => 'Capability already exists'], 403);
        }

        // Create a new module capability
        ModuleCapability::create([
            'module_id' => $module->id,
            'name' => $request->type,
            'data' => json_decode($request->data)
        ]);

        // Clear the module cache
        Cache::clear('modules');

        // Check if the request came from JavaScript
        if($request->wantsJson()) {
            // Return the redirect url
            return response()->json(['redirect_url' => route('modules.show', $module->uid)], 202);
        }

        // Just redirect to the module show view
        return redirect()->route('modules.show', $module->uid);
    }
    
    /**
     * Deletes the selected capability
     * @param module The Module UID
     * @param capability The name of the capability to delete
     * @param request The NOT authenticated, but validated request
     */
    public function destroy($module, $capability, ModuleCapabilityRequest $request)
    {
        // Get the modules from cache using the provided uid
        $module = Cache::get('modules')->where('uid', $module)->first();
        // Check if the module has not been found
        if(!$module) {
            // Abort with statuscode 404
            abort(404);
            return;
        }

        // Check if the user has permission to update the module
        if(!Auth::check('update', $module)) {
            // Return 402 if the user is not permitted
            abort(402);
            return;
        }
    
        // Get the capability where and filter for the capability name, then delete it
        $module->capabilities()->where('name', $capability)->delete();
        
        // Clear the modules cache
        Cache::clear('modules');

        // Check if the request came from JavaScript
        if($request->wantsJson()) {
            // Return the redirect url
            return response()->json(['redirect_url' => route('modules.show', $module->uid)]);
        }

        // Just redirect tothe module show view
        return redirect()->route('modules.show', $module->uid);
    }
}
