<?php

namespace App\Services\impl;

use App\Events\Leaderboard;
use App\Models\Enrollment;
use App\Models\Point;
use App\Models\UserActivity;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;

class UserServicesImpl implements UserServices
{
    private function getLeaderboard()
    {
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

        return $leaderboard;
    }

    public function CourseIsEnroll($course_id): bool
    {
        // find data
        $model = Enrollment::where('user_id', Auth::user()->id)->where('course_id', $course_id)->where('is_confirmed', true)->get();

        return $model->isEmpty();
    }

    public function CreateuserActivity($data)
    {
        $response = ['is_error' => false];

        $model = new UserActivity;
        $model->user_id = $data['user_id'];
        $model->type = $data['type'];
        $model->reference_id = isset($data['reference_id']) ? $data['reference_id'] : null;
        try {
            $model->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();

            return [$model, $response];
        }
        if ($data['type'] == 'claim') {
            $point_model = new Point;
            $point_model->user_id = $data['user_id'];
            $point_model->amount = $data['mission']['reward'];
            $point_model->type = 'debit';
            $point_model->description = 'Claim [title:'.$data['mission']['title'].'], [reference_id:'.$model->id.']'.'[mission_id:'.$data['mission']['title'].']';

            try {
                $point_model->save();
            } catch (\Throwable $th) {
                $response['is_error'] = true;
                $response['error']['code'] = $th->getCode();
                $response['error']['message'] = $th->getMessage();

                return [$model, $response];
            }
            $leaderboard = $this->GetLeaderBoard();
            $ld = $leaderboard->toArray();
            broadcast(new Leaderboard($ld));
        }
        if ($data['type'] == 'claim_practice') {
            $point_model = new Point;
            $point_model->user_id = $data['user_id'];
            $point_model->amount = $data['game']->reward;
            $point_model->type = 'debit';
            $point_model->description = 'Claim Reward Practice[ID:'.$data['game']->id.'], [reference_id:'.$model->id.'';
            try {
                $point_model->save();
            } catch (\Throwable $th) {
                $response['is_error'] = true;
                $response['error']['code'] = $th->getCode();
                $response['error']['message'] = $th->getMessage();

                return [$model, $response];
            }
            $leaderboard = $this->GetLeaderBoard();
            $ld = $leaderboard->toArray();
            broadcast(new Leaderboard($ld));
        }

        return [$model, $response];
    }

    public function GetUserActivityByType($userid, $type, $referenceid = null)
    {

        $response = ['is_error' => false];

        if ($referenceid != null) {
            try {
                $model = UserActivity::where('user_id', '=', $userid)->where('type', '=', $type)->where('reference_id', '=', $referenceid)->get();
            } catch (\Throwable $th) {
                $response['error']['code'] = $th->getCode();
                $response['error']['message'] = $th->getMessage();
            }

            return [$model, $response];
        } else {
            try {
                $model = UserActivity::where('user_id', '=', $userid)->where('type', '=', $type)->where('reference_id', '=', $referenceid)->get();
            } catch (\Throwable $th) {
                $response['error']['code'] = $th->getCode();
                $response['error']['message'] = $th->getMessage();
            }

            return [$model, $response];

        }
    }
}
