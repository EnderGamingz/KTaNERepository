<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ModuleResource;
use Cache;

class ModuleController extends Controller
{
    /**
     * @param module The Module Id to show
     * @param request The HTTP Request
     * @return Response A new response object containg the requested information
     */
    public function show($module, Request $request)
    {
        $request->validate([
            'legacy' => 'nullable|boolean',
            'prettify' => 'nullable|boolean',
        ]);

        $module = Cache::get('modules')->where('uid', $module)->first();
        // Check if the fetched module exists and if it is public
        if(!$module || !$module->approved) {
            return response()->json(['message' => 'Could not find module'], 404);
        }

        $data = null;
        // Check if the legacy json is requested
        if($request->legacy) {
            $data = $this->buildLegacyJson($module);
        } else {
            $data = new ModuleResource($module);
        }

        // Check if the response should be prettified
        if($request->prettify) {
            return response('<pre>' . json_encode($data, JSON_PRETTY_PRINT) . '</pre>');
        }

        return response()->json($data);
    }

    /**
     * This function is for building the legacy json format
     * @param module The module information
     * @return array The build json array in the legacy format
     */
    private function buildLegacyJson($module)
    {
        // Setting the default data
        $data = [
            "Name" => $module->name,
            "Description" => $module->description,
            "ExpertDifficulty" => str_replace(' ', '', $module->difficultyToString($module->expert_difficulty)),
            "DefuserDifficulty" => str_replace(' ', '', $module->difficultyToString($module->defuser_difficulty)),
            "SteamID" => $module->steam_id,
            "Published" => $module->created_at->format('yy-m-d'),
            "Author" => $module->publisher->username,
            "ModuleID" => $module->uid,
            "SortKey" => $module->sortKey(),
            "Origin" => 'Mods', // It will always return mods
        ];

        $sourceUrl = $module->links->where('name', 'github')->first();
        if($sourceUrl) {
            $data["SourceUrl"] = $sourceUrl->link;
        }

        // Building the metadata array
        $metadata = $module->metadata->pluck('value', 'key')->toArray();
        // Making an empty array for capabilities
        $capabilities = [];
        // Iterating over all module capabilities
        foreach ($module->capabilities as $capability) {
            // Overwrite the current capabilities array with the merged data
            $capabilities = array_merge($capabilities, $capability->data);
        }
        // Merge the capablities and metadata
        $data = array_merge($data, $metadata, $capabilities);

        // Returing the data
        return $data;
    }
}
