<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KosResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'price' => $this->price,
            'price_formatted' => 'Rp ' . number_format($this->price, 0, ',', '.'),
            'gender' => $this->gender,
            'gender_label' => $this->getGenderLabel(),
            'description' => $this->description,
            'whatsapp' => $this->whatsapp,
            'phone' => $this->phone,
            'is_premium' => $this->is_premium,
            'is_active' => $this->is_active,
            'status' => $this->status,
            'average_rating' => $this->average_rating,
            'review_count' => $this->review_count,
            'facilities' => FacilityResource::collection($this->whenLoaded('facilities')),
            'primary_photo' => new PhotoResource($this->whenLoaded('primaryPhoto')),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'owner' => new UserResource($this->whenLoaded('owner')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    protected function getGenderLabel(): string
    {
        return match ($this->gender) {
            'putra' => 'Putra',
            'putri' => 'Putri',
            'campur' => 'Campur',
            default => ucfirst($this->gender),
        };
    }
}
