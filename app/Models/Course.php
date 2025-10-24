<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['title', 'description', 'course_categories_id', 'user_id', 'image_id'];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_categories_id');
    }

    public function user()
    {
        return $this->belongsTo(CourseCategory::class, 'user_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function question()
    {
        return $this->hasMany(Question::class);

    }

    public function level()
    {
        return $this->hasMany(Level::class);
    }
}

