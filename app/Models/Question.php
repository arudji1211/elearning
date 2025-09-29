<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory, HasUuid;

    protected $fillable = [
        'task_id',
        'description',
        'image_id',
        'level_id',
    ];

    public function level(){
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
