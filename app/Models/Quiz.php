<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory,HasUuid;

    protected $fillable = [
        'title',
        'nilai_kelulusan',
        'reward',
        'event_start',
        'event_stop',
        'durasi_pengerjaan',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function activities()
    {
        return $this->hasMany(QuizActivity::class);
    }

}
