<?php

namespace App\Http\Controllers;

use App\Services\CourseServices;
use App\Services\PointService;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    private CourseServices $course_services;
    private UserServices $user_services;
    private PointService $point_services;

    public function __construct(CourseServices $coursesvc, UserServices $usersvc, PointService $pointsvc)
    {
        $this->course_services = $coursesvc;
        $this->user_services = $usersvc;
        $this->point_services = $pointsvc;
    }

    public function apiLeaderboard(){
        $leaderboard = $this->point_services->getLeaderboard();
        return response()->json($leaderboard);
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
        $data = $data->toArray();
        for($i = 0;$i < count($data['contents']); $i++){
            if(!isset($data['contents'][$i]['berkas_pendukung'])){
                continue;
            }
            for($o = 0; $o < count($data['contents'][$i]['berkas_pendukung']);$o++){
                $data['contents'][$i]['berkas_pendukung'][$o]['file_endpoint'] = route('rmc.berkas_pendukung.download', ['berkas_id'=>$data['contents'][$i]['berkas_pendukung'][$o]['id']]);
                $data['contents'][$i]['berkas_pendukung'][$o]['delete_endpoint'] = route('rmc.berkas_pendukung.delete', ['berkas_id'=>$data['contents'][$i]['berkas_pendukung'][$o]['id']]);
            }
        }
        $data = json_decode(json_encode($data));
        $leaderboard = $this->point_services->getLeaderboard();
        return view('student.course_detail', compact(['data', 'leaderboard']));
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
