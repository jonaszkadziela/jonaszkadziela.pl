<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'link' => $this->link,
            'translations' => $this->translations ?? [],
            'issuedAt' => $this->issued_at,
            'image' => $this->getMainPicture()?->getUrl(),
        ];
    }
}
