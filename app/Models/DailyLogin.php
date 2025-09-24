<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLogin extends Model
{
    /** @use HasFactory<\Database\Factories\DailyLoginFactory> */
    use HasFactory;
    protected $table = 'daily_logins';

    protected $fillable = [
        'event_start',
        'event_stop',
        'reward',
    ];

    public function loginActivities()
    {
        return $this->hasMany(LoginActivity::class);
    }
}
