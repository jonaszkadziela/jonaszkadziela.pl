<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'sections' => $this->sections,
            'translations' => $this->translations,
            'updatedAt' => $this->updated_at->diffForHumans() . ' (' . $this->updated_at->toDateString() . ')',
        ];
    }
}
