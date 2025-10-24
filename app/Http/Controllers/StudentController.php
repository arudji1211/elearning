<?php

namespace App\Http\Controllers;

use App\Services\CourseServices;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    private CourseServices $course_services;
    private UserServices $user_services;

    public function __construct(CourseServices $coursesvc, UserServices $usersvc)
    {
        $this->course_services = $coursesvc;
        $this->user_services = $usersvc;
    }

    //
    public function showDashboard()
    {
        $user = Auth::user();
        $enroll = Auth::user()->enrollment;
        $course = $this->course_services->GetAllCourse(10);
        return view('student.dashboard', compact('course','user', 'enroll'));
    }

    public function showCourse($id){
        $data = $this->course_services->GetCourseByID($id);
        return view('student.course_detail', compact(['data']));
    }

    public function showCourseEnroll($id){
        if (!$this->user_services->CourseIsEnroll($id)){
            // arahkan kehalaman course
        }
        $course = $this->course_services->GetCourseByID($id);

        return view('student.enroll_course', compact('course'));
    }

    public function CourseEnroll($id){
        $course = $this->course_services->CreateEnrollment($id);
        return redirect()->route('student.dashboard');
    }


}
