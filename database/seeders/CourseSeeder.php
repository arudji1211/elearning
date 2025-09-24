<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseCategory;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 10 course dengan kategori otomatis
        Course::factory()->count(10)->create();

        // contoh manual
        $programming = CourseCategory::firstOrCreate([
            'title' => 'Programming',
        ], [
            'description' => 'Learn to code with multiple languages.'
        ]);

        Course::create([
            'title' => 'Laravel for Beginners',
            'description' => 'Basic introduction to Laravel framework.',
            'course_categories_id' => $programming->id,
        ]);
    }
}
