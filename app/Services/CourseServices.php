<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface CourseServices{
    function GetAllCourseCategory(int $perpage): LengthAwarePaginator;
    function GetAllSoal(int $perpage): LengthAwarePaginator;
    function CreateCourseCategory(string $title, string $description): array;
    function UpdateCourse($id, Request $request);
    function CreateCourse(Request $request): array;
    function GetAllCourse(int $perpage): LengthAwarePaginator;
    function GetCourseByID(string $id);
    function DeleteCourse($id);
    function CreateContents(Request $request, $id);
    function UpdateContents(Request $request, $content_id);
    function DeleteContents($id);
    function CreateLevel(Request $request);
    function GetAllLevel();
    function CreateSoal(Request $request);
    function UpdateSoal(Request $request, $id);
    function CreateTask(Request $request, $course_id, $content_id);
    function CreateEnrollment($course_id);
    function GetEnrollmentByCourseId($course_id);
    function ConfirmEnrollment($id);
    function DeclineEnrollment($id);
    function PointAdjustment($user_id, $tipe, $amount, $description);
    function getLeaderBoard();
    function CreateBerkas($course_id,$request);
    function GetBerkas($berkas_id);
    function DeleteBerkas($berkas_id);
    function GetUserByRole($rolename);
    function DeleteCourseCategory($id);
    function UpdateCourseCategory($id, $request);
    //function GetContentsByCourseID(Request $request,$id):LengthAwarePaginator;
    //function GetContentsByID($id);
    function UpdateLevel($id, $request);
    function DeleteLevel($id);
}
?>
