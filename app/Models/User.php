<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuid, HasApiTokens;

    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'image_id',
        'username',
        'remember_token'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}

