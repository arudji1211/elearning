<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\CourseServices;

class ResourcesManagerController extends Controller
{

    private CourseServices $course_services;

    public function __construct(CourseServices $coursesvc)
    {
        $this->course_services = $coursesvc;
    }

    //
    //
    public function DownloadBerkasPendukung($berkas_id, Request $request){
        $fileinformation = $this->course_services->GetBerkas($berkas_id);
        return Storage::disk('public')->download($fileinformation['data']['filepath']);
    }
}
