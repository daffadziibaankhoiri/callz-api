<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $guarded = ['id']; // Mempermudah mass assignment kecuali ID

    public function packageCategory(): BelongsTo
    {
        return $this->belongsTo(PackageCategory::class);
    }
    public function jobCategory(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class);
    }
    // Relasi lainnya (User & Mitra)
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function mitra(): BelongsTo { return $this->belongsTo(Mitra::class); }
    public function rating()
{
    return $this->hasOne(TaskRating::class);
}
}
