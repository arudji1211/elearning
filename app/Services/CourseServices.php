<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

interface CourseServices{
    function GetAllCourseCategory(int $perpage): LengthAwarePaginator;
    function CreateCourseCategory(string $title, string $description): array;

}

?>
