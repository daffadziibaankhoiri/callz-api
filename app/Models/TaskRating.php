<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'user_rating',
        'user_review',
        'mitra_id',
        'mitra_rating',
        'mitra_review',
    ];

    // Hubungan ke tabel Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Hubungan ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan ke tabel Mitra
    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
    
}