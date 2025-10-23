<?php

namespace App\Http\Controllers;

use App\Services\CourseServices;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private CourseServices $course_services;

    public function __construct(CourseServices $coursesvc)
    {
        $this->course_services = $coursesvc;
    }

    //
    public function createTask(Request $request, $course_id, $content_id,){
        $validate = $request->validate([
            'title' => 'required|string',
            'event_start' => 'required',
            'event_stop' => 'required',
            'reward' => 'required',
        ]);

        $data = $this->course_services->CreateTask($request,$course_id, $content_id);

        if ($data["is_error"]){
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back();
        }
    }
}
