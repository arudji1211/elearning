<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\TaskQuestionFactory> */
    use HasFactory;
    protected $fillable = ['question_id', 'task_id'];

    public function task(){
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function question(){
        return $this->hasOne(Question::class, 'question_id', 'id');
    }

}
