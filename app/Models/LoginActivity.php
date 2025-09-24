<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    /** @use HasFactory<\Database\Factories\LoginActivityFactory> */
    use HasFactory,HasUuid;

    protected $table = 'login_activities';

    protected $fillable = [
        'user_id',
        'daily_login_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyLogin()
    {
        return $this->belongsTo(DailyLogin::class, 'daily_login_id');
    }
}
