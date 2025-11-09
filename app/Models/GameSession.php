<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameSession extends Model
{
    /** @use HasFactory<\Database\Factories\GameSessionFactory> */
    use HasFactory, HasUuid;

    protected $fillable = ['game_id','user_id','status','result'];

    public function game(){
        return $this->BelongsTo(Game::class, 'game_id', 'id');
    }
}
