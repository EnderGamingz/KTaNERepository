<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ModuleResource;
use Cache;

class ModuleController extends Controller
{
    public function show($module, Request $request)
    {
        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            return response()->json(404);
        }

        return new ModuleResource($module);
    }
}
