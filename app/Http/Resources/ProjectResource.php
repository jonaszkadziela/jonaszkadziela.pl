<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $mainPicture = $this->getMainPicture();

        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link,
            'translations' => $this->translations ?? [],
            'isProBono' => $this->is_pro_bono,
            'startedAt' => $this->started_at->isoFormat('MMM Y'),
            'finishedAt' => $this->finished_at?->isoFormat('MMM Y'),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'image' => $mainPicture?->getUrl(),
            'isImagePhoneRender' => $mainPicture ? Str::contains($mainPicture->storage_path, '-phone') : false,
            'route' => '/portfolio/' . $this->slug,
        ];
    }
}
