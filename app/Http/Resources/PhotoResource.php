<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kos_id' => $this->kos_id,
            'url' => $this->url,
            'full_url' => resolve_image_url($this->url),
            'order' => $this->order,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
