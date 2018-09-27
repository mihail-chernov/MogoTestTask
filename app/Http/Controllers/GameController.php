<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \App\Team;
use \App\Game;
use Psy\Exception\RuntimeException;
use \App\Http\Models\Gameplay;


class GameController extends BaseController
{
    public function index() {
        $games = Game::with(['team1', 'team2'])->get();

        return view('games', array(
            'games' => $games
        ));
    }

    public function generateGames() {

        $divATeamCount = Team::where("division",'A')->count();
        $divBTeamCount = Team::where('division','B')->count();

        if ($divATeamCount < Gameplay::teamsToSemiFinal or $divBTeamCount < Gameplay::teamsToSemiFinal) {
            throw new \RuntimeException('Teams count in division must be not less than '.Gameplay::teamsToSemiFinal);
        }

        $gameplayModel = new Gameplay();
        $gameplayModel->playTournament();
        return response()->json(["success" => true]);
    }
}