<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OmzetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_completed_tasks' => $this->total_completed_tasks,
            'omzet'                 => $this->omzet,
            'omzet_formatted'       => 'Rp ' . number_format($this->omzet, 0, ',', '.'),
            'laba_bersih'           => $this->laba_bersih,
            'laba_bersih_formatted' => 'Rp ' . number_format($this->laba_bersih, 0, ',', '.'),
            'persentase_laba'       => '20%',
            'breakdown'             => [
                'total_base_fee'         => $this->breakdown['total_base_fee'],
                'total_job_category_fee' => $this->breakdown['total_job_category_fee'],
                'total_distance_fee'     => $this->breakdown['total_distance_fee'],
                'total_tips_fee'         => $this->breakdown['total_tips_fee'],
                'total_discount'         => $this->breakdown['total_discount'],
            ],
            'filter' => $this->filter,
        ];
    }
}