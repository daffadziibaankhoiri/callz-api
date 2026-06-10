<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'status'                => $this->status,
            'pickup_address'        => $this->pickup_address,
            'pickup_latitude'       => $this->pickup_latitude ? (float) $this->pickup_latitude : null,
            'pickup_longitude'      => $this->pickup_longitude ? (float) $this->pickup_longitude : null,
            'destination_address'   => $this->destination_address,
            'destination_latitude'  => $this->destination_latitude ? (float) $this->destination_latitude : null,
            'destination_longitude' => $this->destination_longitude ? (float) $this->destination_longitude : null,
            'location_notes'        => $this->location_notes,
            'title'                 => $this->title,
            'receiver_name'         => $this->receiver_name,
            'receiver_phone'        => $this->receiver_phone,
            'package_category_id'   => $this->package_category_id,
            'category_name'         => $this->packageCategory?->name,
            'base_fee'              => $this->base_fee,
            'additional_fee'        => $this->additional_fee,
            'discount'              => $this->discount,
            'total_estimated_fee'   => $this->total_estimated_fee,
            'user_id'               => $this->user_id,
            'mitra_id'              => $this->mitra_id,
            'created_at'            => $this->created_at?->toISOString(),
            'proof_of_work'         => $this->proof_of_work,
            // Relasi mitra
            'mitra' => $this->whenLoaded('mitra', fn() => [
                'name'  => trim(($this->mitra?->first_name ?? '') . ' ' . ($this->mitra?->last_name ?? '')) ?: null,
                'phone' => $this->mitra?->phone,
            ]),

            // Rating dari tabel task_ratings
            'user_rating'   => $this->whenLoaded('rating', fn() => $this->rating?->user_rating),
            'user_review'   => $this->whenLoaded('rating', fn() => $this->rating?->user_review),
            'mitra_rating'  => $this->whenLoaded('rating', fn() => $this->rating?->mitra_rating),
            'mitra_review'  => $this->whenLoaded('rating', fn() => $this->rating?->mitra_review),
        ];
    }
}