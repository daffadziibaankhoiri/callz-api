<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Mitra extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
        'password', 'avatar', 'bio', 'domisili', 'is_available', 'latitude', 'longitude', 'rating',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Di dalam App\Models\Mitra

    public function verification()
    {
        return $this->hasOne(MitraVerification::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}