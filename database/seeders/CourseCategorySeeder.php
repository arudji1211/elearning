<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategorySeeder extends Seeder
{
    public function run(): void
    {
        CourseCategory::factory()->count(5)->create();

        // contoh kategori manual
        CourseCategory::create([
            'title' => 'Programming',
            'description' => 'Learn various programming languages and frameworks.',
        ]);

        CourseCategory::create([
            'title' => 'Design',
            'description' => 'UI/UX, Graphic Design, and more.',
        ]);
    }
}

