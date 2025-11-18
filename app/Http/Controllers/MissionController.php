<?php

namespace App\Http\Controllers;

use App\Services\MissionServices;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissionController extends Controller
{
    //
    //
    private MissionServices $mission_services;

    private UserServices $user_services;

    public function __construct(MissionServices $mission_services, UserServices $user_services)
    {
        $this->mission_services = $mission_services;
        $this->user_services = $user_services;
    }

    public function createMission(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'reward' => 'required|integer',
            'type' => 'required|string',
            'progress_requirement' => 'required|integer',
            'mission_start' => 'required',
            'mission_end' => 'required',
        ]);

        [$mission, $error] = $this->mission_services->CreateMission($request);
        if ($error['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $error['error']]);
        }

        return redirect()->back()->with(['success' => true]);
    }

    public function updateMission($id, Request $request){
        $validate = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'reward' => 'required|integer',
            'type' => 'required|string',
            'progress_requirement' => 'required|integer',
            'mission_start' => 'required',
            'mission_end' => 'required',
        ]);
        [$mission, $error] = $this->mission_services->UpdateMission($id,$request);
        if ($error['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $error['error']]);
        }

        return redirect()->back()->with(['success' => true]);

    }

    public function deleteMission($id){
        [$mission,$error] = $this->mission_services->DeleteMission($id);
        if ($error['is_error']) {
            return redirect()->back()->withErrors(['error_details' => $error['error']]);
        }

        return redirect()->back()->with(['success' => true]);

    }

    public function apiMission()
    {
        $user = Auth::user();
        [$mission,$error] = $this->mission_services->GetMissionActive($user->id);

        return response()->json(
            [
                'success' => true,
                'message' => 'sukses mengambil event',
                'data' => $mission,
            ]
        );
    }

    public function apiClaimMission($id, Request $request)
    {
        $user = Auth::user();

        // getmission
        $mission = $this->mission_services->GetMissionByID($id, $user->id);
        if ($mission->can_claim) {
            $data_claim = [
                'user_id' => $user->id,
                'type' => 'claim',
                'reference_id' => $id,
                'mission' => json_decode(json_encode($mission),true),
            ];


            [$activity, $error] = $this->user_services->CreateuserActivity($data_claim);

            if ($error['is_error']) {
                return response()->json([
                    'success' => $error['is_error'],
                    'message' => 'event gagal diclaim',
                    'data' => $error['error'],
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'berhasil mendapatkan ' . $mission->reward . ' point',
                    'data' => $mission,
                ]);
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => 'event hanya dapat di claim 1x',
            ]);
        }

    }
}
