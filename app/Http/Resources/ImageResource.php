<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request)
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
