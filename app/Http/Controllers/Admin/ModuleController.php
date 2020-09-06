<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Module;
use App\Tag;
use App\Http\Requests\ModuleRequest;
class ModuleController extends Controller
{
    public function index(ModuleRequest $request)
    {
        $modules = Module::all();
        return view('admin.modules.index', ['modules' => $modules]);
    }

    public function create(ModuleRequest $request)
    {
        return view('admin.modules.create');
    }
}
