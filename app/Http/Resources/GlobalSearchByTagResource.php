<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GlobalSearchByTagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'results' => [
                'documents' => DocumentResource::collection($this->documents),
                'posts' => PostResource::collection($this->posts),
                'projects' => ProjectResource::collection($this->projects),
            ],
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
