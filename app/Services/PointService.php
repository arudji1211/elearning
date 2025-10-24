<?php

namespace App\Services;

interface PointService{
    function getLeaderboard();
    function PointAdjustment($user_id, $tipe, $amount, $description = 'nil');
}

?>
