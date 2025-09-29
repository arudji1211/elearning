<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory,HasUuids;

    protected $fillable = ['title', 'content_id', 'event_start', 'event_stop'];

    public function contents(){
        return $this->belongsTo(Content::class, 'content_id', 'id');
    }

    public function taskquestion(){
        return $this->hasMany(TaskQuestion::class, 'task_id', 'id');
    }
}
