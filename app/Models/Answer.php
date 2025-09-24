<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
        'image_id',
        'question_id',
        'is_true',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
