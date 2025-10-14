<?php

namespace App\Services\impl;

use App\Models\Answer;
use App\Models\Content;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Enrollment;
use App\Models\Image;
use App\Models\Level;
use App\Models\Point;
use App\Models\Question;
use App\Models\Task;
use App\Models\TaskQuestion;
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
        return Course::with(['contents' => function($query){
                    $query->orderBy('chapter')->with('task');
                },'level','question.level'])->find($id);
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


    public function CreateSoal(Request $request, $id)
    {
        $response = ['is_error' => false];

        try {
            if($request->has('soal_image')){
                $path_soal_image = $request->file('soal_image')->store('images', 'public');
                $id_image_soal = Image::Create(['path' => $path_soal_image]);
            }


            $answer = [];
            foreach($request->answer as $a){
                if(isset($a['image'])){
                    $path = $a->file('image')->store('images', 'public');
                    $image = Image::create(['path' => $path]);
                    $ans['image_id'] =  $image->id;
                }

                $ans['description'] = $a['description'];

                if(isset($a['is_true'])){
                    $ans['is_true'] = true;
                }else{
                    $ans['is_true'] = false;
                }

                $answer[] = $ans;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
        }


        // simpan data soal terlebih dahulu
        $model_soal = new Question;
        $model_soal->description = $request->soal_description;
        $model_soal->course_id = $id;
        $model_soal->level_id = $request->level_id;
        if(isset($id_image_soal)){
            $model_soal->image_id = $id_image_soal;
        }

        // simpan data jawaban
        $model_question = [];
        foreach($answer as $a){
            $m = new Answer;
            $m->description = $a['description'];
            if(isset($a['image_id'])){
                $m->image_id = $a['image_id'];
            }
            $m->is_true = $a['is_true'];
            $model_question[] = $m;
        }



        try {
            $model_soal->save();
        } catch (\Throwable $th) {
            //throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
        }


        foreach($model_question as $a){
            try {
                $a->question_id = $model_soal->id;
                $a->save();
            } catch (\Throwable $th) {
            //throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
            }
        }

        return $response;
    }

    public function CreateTask(Request $request, $course_id, $content_id){
        $response = ['is_error' => false];

        $model_task = new Task;
        $model_task->title = $request->title;
        $model_task->event_start = $request->event_start;
        $model_task->event_stop = $request->event_stop;
        $model_task->content_id = $content_id;
        try {
            $model_task->save();
        } catch (\Throwable $th) {
            //throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
        }

        $task_question_bucket = [];
        foreach($request->soal as $s){
            $model_task_question = new TaskQuestion;
            $model_task_question->task_id = $model_task->id;
            $model_task_question->question_id = $s;
            $task_question_bucket[] = $model_task_question;
        }


        foreach($task_question_bucket as $t){
            try {
                $t->save();
            } catch (\Throwable $th) {
                //throw $th;
                $response['is_error'] = true;
                $response['error']['code'] = $th->getCode();
                $response['error']['message'] = $th->getMessage();
                return $response;
            }
        }

        return $response;
    }

    function CreateEnrollment($id_course){
        $response = ['is_error' => false];

        $model = Enrollment::where('user_id', Auth::user()->id)->where('course_id', $id_course)->where("is_confirmed", true)->get();
        if (!$model->isEmpty()){
            $response['is_error'] = true;
            $response['error']['code'] = 200;
            $response['error']['message'] = 'duplicate data';
            return $response;
        }

        $model_enrollment = new Enrollment;
        $model_enrollment->user_id = Auth::user()->id;
        $model_enrollment->course_id = $id_course;
        $model_enrollment->is_confirmed = false;
        try {
            $model_enrollment->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
            return $response;
        }

        return $response;
    }

    function GetEnrollmentByCourseId($course_id)
    {
        $response = ['is_error' => false];

        try {
            $model = Enrollment::with(['user'])->where('course_id', $course_id)->get();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
            return $response;
        }

        $response['data']['enrollments'] = $model;
        return $response;
    }

    function ConfirmEnrollment($id){
        $response = ['is_error' => false];

        $model = Enrollment::find($id);
        if ($model != null){
            $model->is_confirmed = true;
        }else{
            $response['is_error'] = true;
            $response['error']['code'] = 404;
            $response['error']['message'] = "Enrollment Is Not Found";
            return $response;
        }

        try {
            $model->save();
        } catch (\Throwable $th) {
            //throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
            return $response;
        }

        return $response;
    }


    function DeclineEnrollment($id){
        $response = ['is_error' => false];

        $model = Enrollment::find($id);
        if ($model == null){
            $response['is_error'] = true;
            $response['error']['code'] = 404;
            $response['error']['message'] = "Enrollment Is Not Found";
            return $response;
        }

        try {
            $model->delete();
        } catch (\Throwable $th) {
            //throw $th;
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
            return $response;
        }

        return $response;
    }

    function PointAdjustment($course_id, $user_id, $tipe, $amount){
        $response = ['is_error' => false];
        $point_model = new Point;
        $point_model->user_id = $user_id;
        $point_model->course_id = $course_id;
        $point_model->amount = $amount;
        $point_model->type = $tipe;
        $point_model->description = 'adjusted by course owner';


        try{
            $point_model->save();
        }catch (\Throwable $th){
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
            return $response;
        }

        return $response;

    }

}
