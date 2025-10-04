<?php

namespace App\Http\Controllers;

use App\Services\CourseServices;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    private CourseServices $course_services;

    public function __construct(CourseServices $coursesvc)
    {
        $this->course_services = $coursesvc;
    }
    //
    public function createSoal(Request $request, $id){
        $validate = $request->validate([
                'soal_description' => 'required|string',
                'soal_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                'level_id' => 'required|string',
                'answer.*.description' => 'required|string',
                'answer.*.image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            ]);



        $data = $this->course_services->CreateSoal($request,$id);

        if ($data["is_error"]){
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back();
        }
    }

    //
}
