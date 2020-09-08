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
            'name' => $this->name,
            'description' => $this->description,
            'defuser_difficulty' => $this->defuser_difficulty,
            'expert_difficulty' => $this->expert_difficulty,
            'credits' => $this->credits,
            'publisher' => $this->publisher->username,
            'links' =>  ModuleLinkResource::collection($this->links),
            'tags' => $this->tags ? $this->tags->pluck('name') : [],
        ];
    }
}
