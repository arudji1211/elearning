<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    /** @use HasFactory<\Database\Factories\MissionFactory> */
    use HasFactory, HasUuid;

    protected $fillable = ['id', 'title', 'description', 'reward', 'type', 'mission_start', 'mission_end', 'is_daily', 'progres_requirement'];
    protected $casts = [
        'is_daily' => 'boolean'
    ];
}
