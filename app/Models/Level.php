<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory,HasUuid;

    protected $fillable = ['level', 'delay', 'course_id'];

    public function question(){
        return $this->hasMany(Question::class, 'level_id', 'id');
    }

    public function course(){
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
