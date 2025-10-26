<?php
namespace App\Services\impl;

use App\Models\Enrollment;
use App\Models\UserActivity;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserServicesImpl implements UserServices{

    public function CourseIsEnroll($course_id): bool
    {
        //find data
        $model = Enrollment::where('user_id', Auth::user()->id)->where('course_id', $course_id)->where("is_confirmed", true)->get();
        return $model->isEmpty();
    }

    public function CreateuserActivity($data)
    {
        $model = new UserActivity;
        $model->user_id = $data['user_id'];
        $model->type = $data['type'];
        $model->reference_id = isset($data['reference_id']) ? $data['reference_id'] : null;
        try{
            $model->save();
        }catch (\Throwable $th){

        }
        return;
    }
}
?>
