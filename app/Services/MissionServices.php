<?php

namespace App\Services;

interface MissionServices{
    function GetAllMission();
    function CreateMission($request);
    function GetMissionActive($user_id);
    function GetMissionByID($id, $user_id);
}

?>
