<?php

namespace App\Http\Controllers;

use App\Services\CourseServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourcesManagerController extends Controller
{
    private CourseServices $course_services;

    public function __construct(CourseServices $coursesvc)
    {
        $this->course_services = $coursesvc;
    }

    //
    //
    public function DownloadBerkasPendukung($berkas_id, Request $request)
    {
        $fileinformation = $this->course_services->GetBerkas($berkas_id);

        return Storage::disk('public')->download($fileinformation['data']['filepath']);
    }

    public function DeleteBerkasPendukung($berkas_id, Request $request)
    {
        $fileinformation = $this->course_services->GetBerkas($berkas_id);

        if (Storage::exists($fileinformation['data']['filepath'])) {
            Storage::delete($fileinformation['data']['filepath']);
        } elseif (Storage::disk('public')->exists($fileinformation['data']['filepath'])) {
            Storage::disk('public')->delete($fileinformation['data']['filepath']);
        }
        $data = $this->course_services->DeleteBerkas($berkas_id);
        if ($data["is_error"]){
            //dd($data);
            return redirect()->back()->withErrors(['error_details'=> $data['error']]);
        }else{
            return redirect()->back()->with("response",$data["data"]);
        }
        return redirect()->back();
    }
}
