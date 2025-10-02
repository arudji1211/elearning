<?php

namespace App\Http\Controllers;

use App\Services\CourseServices;
use Illuminate\Http\Request;

class LevelController extends Controller
{

    private CourseServices $course_services;

    public function __construct(CourseServices $coursesvc)
    {
        $this->course_services = $coursesvc;
    }
    //
    public function createLevel(Request $request, $id){
        $validate = $request->validate([
                'level' => 'required|string',
                'delay' => 'required|integer'
            ]);

        $data = $this->course_services->CreateLevel($request,$id);
        if ($data["is_error"]){
            //dd($data);
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back()->with("response",$data["data"]);
        }
    }
}
