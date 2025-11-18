<?php

namespace App\Services\impl;

use App\Models\Mission;
use App\Models\UserActivity;
use App\Services\MissionServices;

class MissionServicesImpl implements MissionServices
{
    public function GetAllMission()
    {
        $response = ['is_error' => false];
        $mission = Mission::all();

        return [$mission, $response];
    }

    public function GetMissionActive($user_id)
    {
        $error = ['is_error' => false];
        $mission = Mission::whereDate('mission_start', '<=', now()->toDateString())->whereDate('mission_end', '>=', now()->toDateString())->get();
        $mission = $mission->toArray();
        for ($i = 0; $i < count($mission); $i++) {
            $mission[$i]['current_progres'] = $this->CheckProgressMission($user_id, $mission[$i]);

            [$claim, $is_claim] = $this->CheckClaimedMission($mission[$i]['id'], $user_id, $mission[$i]['is_daily']);
            if ($is_claim) {
                $mission[$i]['claim']['status'] = $is_claim;
                $mission[$i]['can_claim'] = false;
            } else {
                $claim = $claim->toArray();
                $mission[$i]['claim'] = $claim;
                $mission[$i]['claim']['status'] = $is_claim;
                $mission[$i]['can_claim'] = $mission[$i]['current_progres'] == $mission[$i]['progres_requirement'] ? true : false;
            }

        }
        $mission = json_decode(json_encode($mission));

        return [$mission, $error];
    }

    public function GetMissionByID($id, $user_id)
    {
        $mission = Mission::find($id);
        $mission = $mission->toArray();
        $mission['current_progres'] = $this->CheckProgressMission($user_id, $mission);

        [$claim, $is_claim] = $this->CheckClaimedMission($mission['id'], $user_id, $mission['is_daily']);
        if ($is_claim) {
            $mission['claim']['status'] = $is_claim;
            $mission['can_claim'] = false;
        } else {
            $claim = $claim->toArray();
            $mission['claim'] = $claim;
            $mission['claim']['status'] = $is_claim;
            $mission['can_claim'] = $mission['current_progres'] == $mission['progres_requirement'] ? true : false;
        }

        $mission = json_decode(json_encode($mission));

        return $mission;
    }

    private function CheckProgressMission($user_id, $mission)
    {
        $progress = 0;
        if ($mission['type'] == 'login') {
            $query = UserActivity::where('type', $mission['type'])->where('user_id', $user_id);

            if ($mission['is_daily']) {
                $query = $query->whereDate('created_at', '=', now()->toDateString());
                $activity = $query->get();
            } else {
                $activity = $query->get();
            }

            if ($activity->isEmpty()) {
                return $progress;
            } else {
                $activity = $activity->toArray();
                $progress = count($activity);
                $progress = $progress >= $mission['progres_requirement'] ? $mission['progres_requirement'] : $progress;

                return $progress;
            }
        } elseif ($mission['type'] == 'course_log') {
            $query = UserActivity::where('type', $mission['type'])->where('user_id', $user_id);

            if ($mission['is_daily']) {
                $query = $query->whereDate('created_at', '=', now()->toDateString());
                $activity = $query->get();
            } else {
                $activity = $query->get();
            }

            if ($activity->isEmpty()) {
                return $progress;
            } else {
                $activity = $activity->toArray();
                $progress = count($activity);
                $progress = $progress >= $mission['progres_requirement'] ? $mission['progres_requirement'] : $progress;

                return $progress;
            }

        }
    }

    private function CheckClaimedMission($id, $user_id, $daily)
    {
        $query = UserActivity::where('type', 'claim')->where('user_id', $user_id)->where('reference_id', $id);
        $daily = boolval($daily);
        if ($daily) {
            $query = $query->whereDate('created_at', now()->toDateString());
        }
        $claim = $query->get();
        if ($claim->isEmpty()) {
            return [$claim, false];
        } else {
            return [$claim, true];
        }
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
        $mission->progres_requirement = $request->progress_requirement;

        try {
            // code...
            $mission->save();

        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

        }

        return [$mission, $response];
    }

    public function UpdateMission($id, $request)
    {
        $response = ['is_error' => false];
        try {
            $mission = Mission::find($id);
            $mission->title = $request->title;
            $mission->description = $request->description;
            $mission->reward = $request->reward;
            $mission->type = $request->type;
            $mission->mission_start = $request->mission_start;
            $mission->mission_end = $request->mission_end;
            $mission->is_daily = $request->has('is_daily') ? 1 : 0;
            $mission->progres_requirement = $request->progress_requirement;
            $mission->save();

        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$mission, $response];
    }

    public function DeleteMission($id){
        $response = ['is_error' => false];
        try{
            $mission = Mission::find($id);
            $mission->delete();
        }catch(\Throwable $th){
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$mission,$response];
    }
}
