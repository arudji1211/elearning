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
    public function createLevel(Request $request){
        $validate = $request->validate([
                'level' => 'required|string',
                'delay' => 'required|integer'
            ]);

        $data = $this->course_services->CreateLevel($request);
        if ($data["is_error"]){
            //dd($data);
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back()->with("response",$data["data"]);
        }
    }

    public function updateLevel($id, Request $request){
        [$data,$error] = $this->course_services->UpdateLevel($id, $request);
        if ($error["is_error"]){
            //dd($data);
            return redirect()->back()->withErrors(['error_details'=> $error['error']]);
        }else{
            return redirect()->back()->with("response",$data);
        }
    }

    public function deleteLevel($id){
        [$data,$error] = $this->course_services->DeleteLevel($id);

        if ($error["is_error"]){
            //dd($data);
            return redirect()->back()->withErrors(['error_details'=> $error['error']]);
        }else{
            return redirect()->back()->with("response",$data);
        }
    }
}
