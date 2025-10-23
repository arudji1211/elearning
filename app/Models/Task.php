<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory,HasUuid;

    protected $fillable = ['title', 'content_id', 'event_start', 'event_stop', 'reward'];



    public function contents(){
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }

    public function taskquestion(){
        return $this->hasMany(TaskQuestion::class, 'task_id', 'id');
    }
}
