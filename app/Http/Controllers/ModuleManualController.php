<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModuleManualRequest;
use App\ModuleManual;
use Cache;
use App\Jobs\ModuleManualJob;
use Storage;
use Str;
class ModuleManualController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($module, ModuleManualRequest $request) {
        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            abort(404, "Module not found");
            return;
        }

        if(!$request->user()->can('view', $module)) {
            abort(404, "Module not found");
            return;
        }

        $manuals = $module->manuals;
    
        if($request->id) {
            $manuals = $manuals->where('id', $request->id);
        }

        if($request->type) {
            $manuals = $manuals->where('type', $request->type);
        }
        
        if($request->lang) {
            $manuals = $manuals->where('language', $request->lang);
        }

        $manual = $manuals->first();
        if(!$manual) {
            abort(404, "No Manual Found");
            return;
        }

        return view('modules.manuals.show', ['module' => $module, 'manual' => $manual]);
    }

    public function store($module, ModuleManualRequest $request)
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

        $files = $request->file('files');
        $htmlCheck = false;
        // Checking if only one HTML File exists
        foreach ($files as $file) {
            // Check if the file extension is 'html'
            if($file->getClientOriginalExtension() != 'html') {
                continue;
            }

            if($htmlCheck) {
                return response()->json(['message' => 'There can only be one HTML file'], 403);
            }

            $htmlCheck = true;
        }

        // Check if at least one html file exists
        if(!$htmlCheck) {
            return response()->json(['message' => 'No HTML File found'], 403);
        }

        // Temporary storing the files
        $directoryName = sha1($module->id.$request->type.$request->language.microtime(false));
        Storage::makeDirectory('temp/' . $directoryName);
        foreach($files as $file) {
            $fileName = base64_encode($file->getClientOriginalName());
            $file->storeAs('temp/' . $directoryName, $fileName);
        }

        $moduleManual = new ModuleManual();
        $moduleManual->module_id = $module->id;
        $moduleManual->language = $request->language;
        $moduleManual->type = $request->type;
        $moduleManual->save();

        $job = ModuleManualJob::dispatch($moduleManual, $directoryName);

        return response()->json($moduleManual, 202);
    }
}
