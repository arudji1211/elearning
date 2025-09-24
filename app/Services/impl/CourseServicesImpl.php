<?php
namespace App\Services\impl;

use App\Models\CourseCategory;

use App\Services\CourseServices;
use Illuminate\Pagination\LengthAwarePaginator;

class CourseServicesImpl implements CourseServices{

    public function GetAllCourseCategory(int $perpage = 10): LengthAwarePaginator{

        $query = CourseCategory::query();

        return $query->paginate($perpage);
    }


    public function CreateCourseCategory(string $title, string $description): array
    {
        $response = ["is_error"=>false];

        $model = new CourseCategory;
        $model->title = $title;
        $model->description = $description;
        try {
            //code...
            $model->save();
        } catch (\Throwable $th) {
            //throw $th;
            $response["is_error"] = true;
            $response["error"]["code"] = $th->getCode();
            $response["error"]["message"] = $th->getMessage();
            return $response;
        }

        $response["is_error"] = false;
        $response["data"]["course_category"]["id"] = $model->id;
        $response["data"]["course_category"]["title"] = $model->title;
        $response["data"]["course_category"]["description"] = $model->description;

        return $response;
    }
}

?>
