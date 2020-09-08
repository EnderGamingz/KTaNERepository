<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class ModuleLinkResource extends JsonResource
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
            'name' => $this->name,
            'link' => $this->link
        ];
    }
}
