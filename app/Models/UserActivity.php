<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserActivity extends Model
{
    /** @use HasFactory<\Database\Factories\UserActivityFactory> */
    use HasFactory,HasUuid;

    protected $fillable = ['type', 'user_id', 'reference_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
