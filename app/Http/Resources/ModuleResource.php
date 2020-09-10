<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class ModuleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uid' => $this->uid,
            'steam_id' => $this->steam_id,
            'name' => $this->name,
            'description' => $this->description,
            'defuser_difficulty' => $this->defuser_difficulty,
            'expert_difficulty' => $this->expert_difficulty,
            'credits' => $this->credits,
            'publisher' => $this->publisher->username,
            'links' =>  ModuleLinkResource::collection($this->links),
            'tags' => $this->tags->pluck('name'),
            'metadata' => ModuleMetadataResource::collection($this->metadata),
            'capabilities' => ModuleCapabilityResource::collection($this->capabilities),
            'maintainer' => $this->maintainer->pluck('username')
        ];
    }
}
