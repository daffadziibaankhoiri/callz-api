<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MitraVerification extends Model
{
    protected $fillable = [
        'mitra_id',
        'foto_ktp',
        'foto_sim',
        'status',
        'rejection_note',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}