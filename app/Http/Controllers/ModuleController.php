<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModuleRequest;
use App\Module;
use App\ModuleLink;
use App\Tag;
use App\ModuleMetadata;
use App\ModuleCapability;
use Cache;
use Auth;

class ModuleController extends Controller
{
    
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
    }
    
    public function create()
    {
        if(!Auth::check()) {
            return;
        }

        return view('modules.create');
    }

    public function store(ModuleRequest $request)
    {
        if(!Auth::check()) {
            return;
        }

        $uid = null;
        $tries = 0;
        
        do {
            $uid = preg_replace('/[^A-Za-z0-9]/i', '', $request->name) . ($tries > 0 ? $tries : '');
            $tries++;
        } while(Cache::get('modules')->contains('uid', $uid));

        $module = new Module();
        $module->name = $request->name;
        $module->description = $request->description;
        $module->steam_id = $request->steam_id;
        $module->uid = $uid;
        $module->credits = $request->credits;
        $module->expert_difficulty = $request->expert_difficulty;
        $module->defuser_difficulty = $request->defuser_difficulty;
        $module->publisher_id = $request->user()->id;
        $module->save();

        if($request->has('tags')) {
            $existingTags = Cache::get('tags')->whereIn('name', $request->tags);
            $creatingTags = collect($request->tags)->filter(function ($item) use ($existingTags) {
                return !$existingTags->contains('name', $item);
            });

            $module->tags()->sync($existingTags);

            if($creatingTags->count() > 0) {
                foreach ($creatingTags as $tagName) {
                    $tag = Tag::create([
                        'name' => $tagName
                    ]);

                    $module->tags()->attach($tag);
                }

                Cache::clear('tags');
            }
        }

        if($request->has('links')) {
            $links = [];
            foreach ($request->links as $linkType => $url) {
                array_push($links, [
                    'module_id' => $module->id,
                    'name' => $linkType,
                    'link' => $url,
                ]);
            }

            ModuleLink::insert($links);
        }

        if($request->has('metadata')) {
            $metadata = [];
            foreach ($request->metadata as $key => $value) {
                array_push($metadata, [
                    'module_id' => $module->id,
                    'key' => $key,
                    'value' => $value
                ]);
            }

            ModuleMetadata::insert($metadata);
        }

        Cache::clear('modules');

        return response()->json(['redirect_url' => route('modules.show', $module->uid)]);
    }

    public function show($module, Request $request)
    {
        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            abort(404);
            return;
        }
        return view('modules.show', ['module' => $module]);
    }

    public function update($module, ModuleRequest $request)
    {
        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            abort(404);
            return;
        }

        if(!$request->user()->can('update', $module)) {
            return;
        }

        dd($module);
    }

    public function destroy($module, ModuleRequest $request)
    {
        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            abort(404);
            return;
        }

        dd($module);
    }

    public function approve($module, ModuleRequest $request)
    {
        $module = Cache::get('modules')->where('uid', $module)->first();
        if(!$module) {
            abort(404);
            return;
        }

        if(!$request->user()->can('approve', $module)) {
            abort(402);
            return;
        }

        $module->approved = true;
        $module->save();

        Cache::clear('modules');

        return redirect()->route('modules.show', $module->uid);
    }
}
