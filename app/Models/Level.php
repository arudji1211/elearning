<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory,HasUuid;

    protected $fillable = ['level', 'delay'];

    public function question(){
        return $this->hasMany(Question::class, 'level_id', 'id');
    }
}
