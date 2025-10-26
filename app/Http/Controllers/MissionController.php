<?php

namespace App\Http\Controllers;

use App\Services\MissionServices;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    //
    //
    private MissionServices $mission_services;

    public function __construct(MissionServices $mission_services)
    {
        $this->mission_services = $mission_services;
    }

    public function createMission(Request $request){
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'reward' => 'required|integer',
            'type' => 'required|string',
            'mission_start' => 'required',
            'mission_end' => 'required',
        ]);


        [$mission, $error] = $this->mission_services->CreateMission($request);
        if($error['is_error']){
            return redirect()->back()->withErrors(['error_details' => $error['error']]);
        }

        return redirect()->back()->with(['success' => true]);
    }
}

