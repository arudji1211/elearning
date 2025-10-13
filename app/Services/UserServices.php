<?php

namespace App\Services;

interface UserServices {
    function CourseIsEnroll($course_id): bool;
}

?>
