<?php

namespace App\Services\impl;

use App\Events\Leaderboard;
use App\Models\Point;
use App\Services\PointService;

class PointServiceImpl implements PointService
{
    public function getLeaderboard() {
        $leaderboard = Point::selectRaw("
        user_id,
        SUM(
            CASE
                WHEN type = 'debit' THEN amount
                WHEN type = 'credit' THEN -amount
                ELSE 0
            END
        ) AS total
    ")
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user.image')
            ->get();
        for($i = 0; $i < count($leaderboard); $i++){
            if($leaderboard[$i]->user->image != null){
                $leaderboard[$i]->user->image->path = asset( 'storage/' .  $leaderboard[$i]->user->image->path);
            }
        }
        return $leaderboard;
    }

    public function PointAdjustment($user_id, $tipe, $amount, $description = 'nil')
    {
        $response = ['is_error' => false];
        $point_model = new Point;
        $point_model->user_id = $user_id;
        $point_model->amount = $amount;
        $point_model->type = $tipe;
        $point_model->description = $description;

        try {
            $point_model->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return $response;
        }

        // kirim broadcast
        $leaderboard = $this->GetLeaderBoard();
        $ld = $leaderboard->toArray();
        broadcast(new Leaderboard($ld));

        return $response;

    }
}
