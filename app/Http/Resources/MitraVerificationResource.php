<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MitraVerificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'mitra_id'       => $this->mitra_id,
            'mitra'          => new MitraResource($this->whenLoaded('mitra')),
            'foto_ktp'       => asset('storage/' . $this->foto_ktp),
            'foto_sim'       => asset('storage/' . $this->foto_sim),
            'status'         => $this->status,
            'rejection_note' => $this->rejection_note,
            'created_at'     => $this->created_at->toDateTimeString(),
            'updated_at'     => $this->updated_at->toDateTimeString(),
        ];
    }
}