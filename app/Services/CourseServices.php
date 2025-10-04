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
    //function GetContentsByCourseID(Request $request,$id):LengthAwarePaginator;
    //function GetContentsByID($id);
}
?>
