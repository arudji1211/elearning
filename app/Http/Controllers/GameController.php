<?php

namespace App\Http\Controllers;

use App\Services\GameServices;
use App\Services\PointService;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    //
    private GameServices $game_services;

    private UserServices $user_services;

    private PointService $point_services;

    public function __construct(GameServices $gamesvc, UserServices $usersvc, PointService $pointsvc)
    {
        $this->game_services = $gamesvc;
        $this->user_services = $usersvc;
        $this->point_services = $pointsvc;
    }

    public function createGame(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'reward' => 'required|integer',
            'winner_point' => 'required|integer',
        ]);

        [$game, $error] = $this->game_services->CreateGame($request);
        if ($error['is_error']) {
            return redirect()->back()->withErrors($error['error']);

        }

        return redirect()->back()->with('response', $game);

    }

    public function createGameSession($id)
    {
        $user = Auth::user();
        // cek jika ada sesi aktif gunakan sesi tersebut
        [$GameSession,$error] = $this->game_services->GetGameSession($id, $user->id, 'active');
        if ($error['is_error']) {
            return redirect()->back()->withErrors($error['error']);
        }

        if (! $GameSession->isEmpty()) {
            return redirect()->route('student.game.session', ['id' => $id, 'session_id' => $GameSession[0]->id]);
        }

        // create session
        [$GameSession, $error] = $this->game_services->CreateGameSession($id, $user->id);
        if ($error['is_error']) {
            return redirect()->back()->withErrors($error['error']);
        } else {
            return redirect()->route('student.game.session', ['id' => $id, 'session_id' => $GameSession->id]);
        }
    }

    public function showGameSession($id_game, $id_game_session)
    {
        $user = Auth::user();

        $endpoints = [
            'match_data' => route('api.student.game.session', ['id' => $id_game, 'session_id' => $id_game_session]),
            'submit_answer' => route('api.student.game.update.activity', ['id' => $id_game, 'session_id' => $id_game_session]),
            'new_question' => route('api.student.game.create.activity', ['id' => $id_game, 'session_id' => $id_game_session]),
        ];

        $endpoints = json_decode(json_encode($endpoints));

        return view('student.game_session', compact(['user', 'endpoints']));
    }

    public function getGameSessionActivity($id_game, $id_game_session)
    {
        [$activity, $error] = $this->game_services->getGameSessionActivity($id_game_session);
        $activity['action']['retry'] = route('student.game.create.session', ['id' => $id_game]);
        $activity['action']['claim'] = route('student.game.session.claim', ['id' => $id_game, 'session_id' => $id_game_session]);
        $activity['action']['home'] = route('student.dashboard');
        if ($error['is_error']) {
            return response()->json([
                'success' => false,
                'message' => 'ada kesalahan',
                'data' => $error['error'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success mengambil data session',
            'data' => $activity,
        ]);
    }

    public function createGameActivity($id_game, $id_session, Request $request)
    {
        [$activity, $error] = $this->game_services->createGameActivity($id_session);
        if ($error['is_error']) {
            return response()->json([
                'success' => false,
                'message' => 'ada kesalahan',
                'data' => $error['error'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success membuat game activity',
            'data' => $activity,
        ]);
    }

    public function claimGameSession($id, $session_id)
    {
        $user = Auth::user();
        [$activity, $error] = $this->game_services->getGameSessionByID($session_id);
        if ($error['is_error']) {
            return redirect()->route('student.dahsboard')->withErrors(['error_details' => $error['error']]);
        }
        $type = 'claim_practice';
        if ($activity->result == 'win' && $activity->can_claim) {
            $data_claim = [
                'user_id' => $user->id,
                'type' => 'claim_practice',
                'reference_id' => $activity->game_id,
                'game' => $activity->game,
            ];
            [$claims, $error] = $this->user_services->CreateuserActivity($data_claim);
            if ($error['is_error']) {
                return redirect()->route('student.dahsboard')->withErrors(['error_details' => $error['error']]);
            }else{
                return redirect()->route('student.dashboard')->with("response", ["Sukses Claim " . $activity->game->reward . " point"]);
            }
        }else{
            return redirect()->route('student.dashboard')->with("response", ["Gagal Claim Reward"]);
        }
    }

    public function updateGameActivity($id_game, $id_session, Request $request)
    {
        [$activity, $error] = $this->game_services->updateGameActivity($request);
        if ($error['is_error']) {
            return response()->json([
                'success' => false,
                'message' => 'ada kesalahan',
                'data' => $error['error'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success update game activity',
            'data' => $activity,
        ]);

    }
}
