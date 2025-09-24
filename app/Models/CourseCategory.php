<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['title', 'description'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'course_categories_id');
    }
}

?>
