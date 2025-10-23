<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface CourseServices{
    function GetAllCourseCategory(int $perpage): LengthAwarePaginator;
    function CreateCourseCategory(string $title, string $description): array;
    function CreateCourse(Request $request): array;
    function GetAllCourse(int $perpage): LengthAwarePaginator;
    function GetCourseByID(string $id);
    function CreateContents(Request $request, $id);
    function DeleteContents($id);
    function CreateLevel(Request $request, $id);
    function GetAllLevel();
    function CreateSoal(Request $request, $id);
    function CreateTask(Request $request, $course_id, $content_id);
    function CreateEnrollment($course_id);
    function GetEnrollmentByCourseId($course_id);
    function ConfirmEnrollment($id);
    function DeclineEnrollment($id);
    function PointAdjustment($course_id, $user_id, $tipe, $amount, $description);
    function getLeaderBoard($course_id);
    function CreateBerkas($course_id,$request);
    function GetBerkas($berkas_id);

    //function GetContentsByCourseID(Request $request,$id):LengthAwarePaginator;
    //function GetContentsByID($id);
}
?>
