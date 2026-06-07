<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kos_id' => $this->kos_id,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'rating_cleanliness' => $this->rating_cleanliness,
            'rating_security' => $this->rating_security,
            'rating_facilities' => $this->rating_facilities,
            'comment' => $this->comment,
            'helpful_count' => $this->helpful_count,
            'is_visible' => $this->is_visible,
            'is_flagged' => $this->is_flagged,
            'user' => new UserResource($this->whenLoaded('user')),
            'kos' => new KosResource($this->whenLoaded('kos')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
