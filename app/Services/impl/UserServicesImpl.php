<?php
namespace App\Services\impl;

use App\Models\Enrollment;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;

class UserServicesImpl implements UserServices{

    public function CourseIsEnroll($course_id): bool
    {
        //find data
        $model = Enrollment::where('user_id', Auth::user()->id)->where('course_id', $course_id)->where("is_confirmed", true)->get();
        return $model->isEmpty();
    }
}
?>
