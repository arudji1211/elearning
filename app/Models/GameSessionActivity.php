<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSessionActivity extends Model
{
    /** @use HasFactory<\Database\Factories\GameSessionActivityFactory> */
    use HasFactory,HasUuid;

    protected $fillable = ['game_session_id', 'question_id', 'answer_id', 'result'];


    public function question(){
        return $this->belongsTo(Question::class, 'question_id', 'id');    }

}
