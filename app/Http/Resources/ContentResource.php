<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'content_type' => new ContentTypeResource($this->whenLoaded('contentType')),
            'user' => new UserResource($this->whenLoaded('user')),
            'media' => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
