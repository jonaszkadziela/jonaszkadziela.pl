<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'body' => $this->body,
            'translations' => $this->translations ?? [],
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'image' => $this->getMainPicture()?->getUrl(),
        ];
    }
}
