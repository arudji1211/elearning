<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['title'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

