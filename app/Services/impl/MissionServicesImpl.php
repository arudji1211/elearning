<?php

namespace App\Services\impl;

use App\Models\Mission;
use App\Services\MissionServices;

class MissionServicesImpl implements MissionServices{
    public function GetAllMission(){
        $response = ['is_error' => false];
        $mission = Mission::all();
        return [$mission ,$response];
    }

    public function CreateMission($request)
    {
        $response = ['is_error' => false];
        $mission = new Mission;

        $mission->title = $request->title;
        $mission->description = $request->description;
        $mission->reward = $request->reward;
        $mission->type = $request->type;
        $mission->mission_start = $request->mission_start;
        $mission->mission_end = $request->mission_end;
        $mission->is_daily = $request->has('is_daily') ? 1 : 0;


        try {
            //code...
            $mission->save();

        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

        }

        return [$mission, $response];
    }
}

?>
