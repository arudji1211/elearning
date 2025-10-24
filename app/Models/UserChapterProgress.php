<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChapterProgress extends Model
{
    //
    use HasFactory, HasUuid;

    protected $fillable = ['content_id', 'user_id'];

    public function contents(){
        return $this->belongsTo(Content::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
