<?php
namespace App\Services;

interface GameServices{
    function GetAllGame();
    function CreateGame($request);
    function UpdateGame($id, $request);
    function DeleteGame($id);
    function GetGameByID($id);
    function GetGameSession($id_game, $id_user, $status);
    function GetGameSessionByID($id_session);
    function CreateGameSession($id_game, $id_user);
    function UpdateGameSessionStatus($id_session, $status,$result);
    function GetGameSessionActivity($id_session);
    function GetNullAnswerGameSessionActivity($id_session);
    function CreateGameActivity($id_session);
    function UpdateGameActivity($request);
}

?>
