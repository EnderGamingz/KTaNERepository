<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModuleManualRequest;
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

        $job = ModuleManualJob::dispatch($module, $directoryName);
    }
}
