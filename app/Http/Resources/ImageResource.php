<?php

namespace App\Http\Resources;

use TiMacDonald\JsonApi\JsonApiResource;

class ImageResource extends JsonApiResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'path' => $this->path,
            'original_name' => $this->original_name,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' =>  $this->updated_at,
        ];
    }
}
