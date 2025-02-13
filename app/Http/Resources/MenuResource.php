<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'route' => $this->route,
            'translations' => $this->translations ?? [],
            'isOnlyInFooter' => $this->is_only_in_footer,
        ];
    }
}
