<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['user_id', 'description', 'course_id', 'type', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

