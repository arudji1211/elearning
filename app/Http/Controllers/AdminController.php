<?php

namespace App\Http\Controllers;

use App\Services\CourseServices;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private CourseServices $course_services;

    public function __construct(CourseServices $coursesvc)
    {
        $this->course_services = $coursesvc;
    }
    //
    public function showDashboard()
    {
        $course = $this->course_services->GetAllCourse(10);
        return view('admin.dashboard', compact('course'));
    }

    public function showCourseCategory()
    {
        $course_categories = $this->course_services->GetAllCourseCategory(5);
        return view('admin.manage_course_category', compact('course_categories'));
    }

    public function showCourse()
    {
        $course = $this->course_services->GetAllCourse(5);
        $categories = $this->course_services->GetAllCourseCategory(1000);
        return view('admin.manage_course', compact('course', 'categories'));
    }

    public function showCourseDetail($id){
        $data = $this->course_services->GetCourseByID($id);
        return view('admin.course.course_detail', compact(['data']));
    }

    public function CreateContent(Request $request, $id){
        $validate = $request->validate([
                'title' => 'required|string',
                'chapter' => 'required|integer',
                'description' => 'required|string'
            ]);

        $data = $this->course_services->CreateContents($request,$id);
        if ($data["is_error"]){
            //dd($data);
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back()->with("response",$data["data"]);
        }

    }

    public function createCourse(Request $request)
    {
        // validasi
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'course_categories_id' => 'required|string',
        ]);

        // hit service
        $data = $this->course_services->CreateCourse($request);
        if ($data["is_error"]){
            //dd($data);
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back()->with("response",$data["data"]);
        }
    }

    public function createCourseCategory(Request $request)
    {
        // validasi
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        // hit service
        $data = $this->course_services->CreateCourseCategory($validate['title'], $validate['description']);
        if ($data["is_error"]){
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back()->with("response",$data["data"]);
        }
    }
}
