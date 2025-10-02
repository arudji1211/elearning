<?php

namespace App\Services\impl;

use App\Models\Content;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Image;
use App\Models\Level;
use App\Services\CourseServices;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CourseServicesImpl implements CourseServices
{
    public function GetAllCourseCategory(int $perpage = 10): LengthAwarePaginator
    {

        $query = CourseCategory::query();

        return $query->paginate($perpage);
    }

    public function GetAllCourse(int $perpage = 10): LengthAwarePaginator
    {

        $query = Course::with(['category','image', 'level']);

        return $query->paginate($perpage);
    }

    public function GetCourseByID(string $id)
    {
        return Course::with(['contents','level'])->find($id);
    }

    public function CreateCourse($request): array
    {
        $response = ['is_error' => false];

        $path = $request->file('image')->store('images', 'public');
        try {
            $path = $request->file('image')->store('images', 'public');

        } catch (\Throwable $th) {
            // throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
        }

        try {
            // code...
            $image = Image::create(['path' => $path]);

        } catch (\Throwable $th) {
            // throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;

        }
        $model = new Course;
        $model->title = $request->title;
        $model->description = $request->description;
        $model->course_categories_id = $request->course_categories_id;
        $model->image_id = $image->id;
        $model->user_id = Auth::user()->id;

        try {
            // code...
            $model->save();
        } catch (\Throwable $th) {
            // throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
        }

        $response['is_error'] = false;
        $response['data']['course']['id'] = $model->id;
        $response['data']['course']['title'] = $model->title;
        $response['data']['course']['description'] = $model->description;
        $response['data']['course']['course_categories_id'] = $model->course_categories_id;

        return $response;
    }

    public function CreateCourseCategory(string $title, string $description): array
    {
        $response = ['is_error' => false];

        $model = new CourseCategory;
        $model->title = $title;
        $model->description = $description;
        try {
            // code...
            $model->save();
        } catch (\Throwable $th) {
            // throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
        }

        $response['is_error'] = false;
        $response['data']['course_category']['id'] = $model->id;
        $response['data']['course_category']['title'] = $model->title;
        $response['data']['course_category']['description'] = $model->description;

        return $response;
    }

    public function CreateContents(Request $request, $course_id)
    {
        $response = ['is_error' => false];

        $model = new Content;
        $model->course_id = $course_id;
        $model->chapter = $request->chapter;
        $model->title = $request->title;
        $model->description = $request->description;
        try {
            $model->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
            return $response;
        }
        $response['is_error'] = false;
        $response['data']['contents'] = $model;
        return $response;
    }

    public function CreateLevel(Request $request, $id)
    {
        $response = ['is_error' => false];
        $model = new Level;
        $model->level = $request->level;
        $model->delay = $request->delay;
        $model->course_id = $id;
        try {
            $model->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
            return $response;
        }
        $response['is_error'] = false;
        $response['data']['contents'] = $model;
        return $response;
    }

    public function GetAllLevel()
    {

    }

    public function DeleteContents($id){
        $model = Content::with('course')->find($id);
        if(Auth::user()->id == $model->course->user_id){
            $model->delete();
            return;
        } else if(Auth::user()->role->title == 'admin'){
            $model->delete();
            return;
        }else{
            $response['is_error'] = true;
            $response['error']['code'] = 403;
            $response['error']['message'] = "Permission Denied";
            return $response;
        }


    }
}
