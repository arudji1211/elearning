<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['course_id', 'chapter', 'title', 'hero', 'description'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function sections()
    {
        return $this->hasMany(ContentSection::class);
    }

    public function berkasPendukung()
    {
        return $this->hasMany(BerkasPendukung::class);
    }
}

