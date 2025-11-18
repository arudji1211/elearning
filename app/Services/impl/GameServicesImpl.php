<?php

namespace App\Services\impl;

use App\Models\Game;
use App\Models\GameSession;
use App\Models\GameSessionActivity;
use App\Models\Question;
use App\Models\UserActivity;
use App\Services\GameServices;
use Carbon\Carbon;

class GameServicesImpl implements GameServices
{
    public function GetAllGame()
    {
        $response = ['is_error' => false];
        $games = Game::all();

        return [$games, $response];
    }

    public function GetGameByID($id)
    {
        $response = ['is_error' => false];
        $game = Game::where('id', $id);
        try {
            $game = $game->get();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        if ($game->isEmpty()) {
            $response['is_error'] = true;
            $response['error']['code'] = 404;
            $response['error']['message'] = 'Game Is Not Found';

            return [$game, $response];
        }

        return [$game, $response];
    }

    public function CreateGame($request)
    {
        $response = ['is_error' => false];
        $game = new Game;
        try {
            $game->title = $request->title;
            if ($request->has('description')) {
                $game->description = $request->description;
            }

            $game->reward = $request->reward;

            if ($request->has('is_daily')) {
                $game->is_daily = $request->is_daily;
            }

            if ($request->has('is_active')) {
                $game->is_active = $request->is_active;
            }

            $game->winner_point = 3;

            $game->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$game, $response];
    }

    public function DeleteGame($id){
        $response = ['is_error' => false];
        try{
            $game = Game::find($id);
            $game->delete();
        }catch(\Throwable $th){
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }
        return [$game, $response];

    }

    public function UpdateGame($id, $request)
    {
        $response = ['is_error' => false];
        try {
            $game = Game::find($id);
            $game->title = $request->title;
            if ($request->has('description')) {
                $game->description = $request->description;
            }

            $game->reward = $request->reward;

            if ($request->has('is_daily')) {
                $game->is_daily = $request->is_daily;
            }else{
                $game->is_daily = false;
            }

            if ($request->has('is_active')) {
                $game->is_active = $request->is_active;
            }else{
                $game->is_active = false;
            }

            $game->winner_point = 3;

            $game->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$game, $response];

    }

    public function GetGameSession($id_game, $id_user, $status)
    {
        $response = ['is_error' => false];
        $game_session = GameSession::where('game_id', $id_game)->where('user_id', $id_user)->where('status', $status);
        try {
            $game_session = $game_session->get();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$game_session, $response];
    }

    public function GetGameSessionByID($id_session)
    {
        $response = ['is_error' => false];
        try {
            $game_session = GameSession::with('game')->find($id_session);
            $query = UserActivity::where('user_id', $game_session->user_id)->where('type', 'claim_practice')->where('reference_id', 'like', $game_session->game->id . '%');
            $daily = boolval($game_session->is_daily);
            if($game_session->game->is_daily){
                $query = $query->whereDate('created_at', now()->toDateString());
            }

            $query = $query->get();
            if($query->isEmpty()){
                $can_claim = true;
            }else{
                $can_claim = false;
            }
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }
        $game_session = $game_session->toArray();
        $game_session['can_claim'] = $can_claim;
        $game_session = json_decode(json_encode($game_session));

        return [$game_session, $response];

    }

    public function UpdateGameSessionStatus($id_session,$status, $result){
        $response = ['is_error' => false];
        $game_session = GameSession::find($id_session);
        $game_session->status = $status;
        $game_session->result = $result;

        try {
            $game_session = $game_session->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$game_session, $response];
    }

    public function CreateGameSession($id_game, $id_user)
    {
        $response = ['is_error' => false];
        $GameSession = new GameSession;
        try {
            $GameSession->game_id = $id_game;
            $GameSession->user_id = $id_user;
            $GameSession->status = 'active';
            $GameSession->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$GameSession, $response];
    }

    public function UpdateGameActivity($request)
    {
        $response = ['is_error' => false];
        $activity = GameSessionActivity::with('question.answers')->with('question.level')->find($request->id);

        $jawaban_benar = '';

        foreach ($activity->question->answers as $a) {
            if ($a->is_true) {
                $jawaban_benar = $a->id;
                break;
            }
        }

        $activity->answer_id = $request->answer_id;
        if ($request->answer_id == $jawaban_benar) {
            $created_at = Carbon::parse($activity->created_at);
            $sekarang = Carbon::now();
            $selisih_user = $created_at->diffInSeconds($sekarang);
            if ($selisih_user <= $activity->question->level->delay) {
                $activity->result = 'win';
            } else {
                $activity->result = 'lose';
            }
        } else {
            $activity->result = 'lose';
        }

        try {
            $activity->save();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$activity, $response];
    }

    public function GetGameSessionActivity($id_session)
    {
        $response = ['is_error' => false];

        [$hasil, $isselesai] = $this->WinnerChecker($id_session);
        if($isselesai){
            $this->UpdateGameSessionStatus($id_session,'inactive',$hasil);
        }
        $activity = [];
        try {
            $activity = GameSessionActivity::with('question.level')->with('question.answers')->where('game_session_id', $id_session)->where('answer_id', '!=', null)->get();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        $data = [];
        foreach ($activity as $a) {
            $person = [
                'status' => '',
                'question_id' => $a->question_id,
                'answer_id' => $a->answer_id,
                'is_benar' => false,
            ];

            $bot = [
                'status' => '',
                'question_id' => $a->question_id,
                'is_benar' => true,
            ];

            foreach ($a->question->answers as $q) {
                if ($q->is_true) {
                    $bot['answer_id'] = $q->id;
                    if ($q->id == $a->answer_id) {
                        $person['is_benar'] = true;
                    }
                }
            }

            $person_delay = $a->created_at->diffInSeconds($a->updated_at);
            if ($person['is_benar']) {
                if ($person_delay <= $a->question->level->delay) {
                    $person['status'] = 'win';
                    $bot['status'] = 'lose';
                } else {
                    $person['status'] = 'lose';
                    $bot['status'] = 'win';
                }

            } else {
                $person['status'] = 'lose';
                $bot['status'] = 'win';
            }

            $temp = ['person' => $person, 'bot' => $bot];
            array_push($data, $temp);
        }

        $datas['active_session'] = GameSessionActivity::with('question.answers')->where('game_session_id', $id_session)->where('answer_id', '=', null)->get();
        $datas['history'] = $data;
        $datas['status'] = $hasil;

        return [$datas, $response];
    }

    public function GetNullAnswerGameSessionActivity($id_session)
    {
        $response = ['is_error' => false];
        $activity = [];
        try {
            $activity = GameSessionActivity::with('question.level')->with('question.answer')->where('id', $id_session)->where('answer_id', '!=', null)->get();
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return $activity;
    }

    public function CreateGameActivity($id_session)
    {
        $response = ['is_error' => false];
        $activity = [];

        try {
            $active = GameSessionActivity::with('question.answers')->where('answer_id', null)->where('game_session_id', $id_session)->get();

            if (! $active->isEmpty()) {
                $activity = $active;
            } else {
                $recent = GameSessionActivity::where('answer_id', '!=', null)->where('game_session_id', $id_session)->get();
                [$question, $response] = $this->QuestionRandomize($recent);
                $activity = GameSessionActivity::create([
                    'game_session_id' => $id_session,
                    'question_id' => $question->id,
                ]);
                $activity->question = $question;
            }
        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['line'] = $th->getLine();
            $response['error']['message'] = $th->getMessage();
        }

        return [$activity, $response];
    }

    private function QuestionRandomize($activity)
    {
        $response = ['is_error' => false];
        $query = Question::with('answers');
        $question_id = [];
        foreach ($activity as $a) {
            $query = $query->where('id', '!=', $a->question_id);
        }

        $question_id = $query->get();

        $question_id = $question_id->toArray();

        $batas = count($question_id) - 1;

        $index = random_int(0, $batas);
        $question_id = json_decode(json_encode($question_id[$index]));

        try {

        } catch (\Throwable $th) {
            $response['is_error'] = true;
            $response['error']['code'] = $th->getCode();
            $response['error']['message'] = $th->getMessage();
        }

        return [$question_id, $response];
    }

    private function WinnerChecker($id_session){
        $query = GameSessionActivity::where('answer_id', '!=', null)->where('game_session_id', $id_session)->get();
        $total_match = count($query);
        $win = 0;
        $lose = 0;
        $result = 'none';
        $done = false;
        foreach($query as $a){

            if($a->result == 'win'){
                $win++;
            }else{
                $lose++;
            }
        }

        if($win == 3){
            $done = true;
            $result = 'win';
        }


        if($lose == 3){
            $result = 'lose';
            $done = true;
        }



        return [$result,$done];
    }
}
