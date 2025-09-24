<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPendukung extends Model
{
    /** @use HasFactory<\Database\Factories\BerkasPendukungFactory> */
    use HasFactory;
    protected $fillable = [
        'filename',
        'content_id',
        'filepath',
    ];
}
