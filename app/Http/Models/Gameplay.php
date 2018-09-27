<?php

namespace App\Http\Models;

use \App\Team;
use \App\Game;

class Gameplay
{
    CONST teamsToSemiFinal = 4;


    public function playTournament() {
        Game::truncate();
        $divisionAChampionsIds = $this->playGamesInOneDivision('A');
        $divisionBChampionsIds = $this->playGamesInOneDivision('B');
        $winnersIds = array_merge($divisionAChampionsIds,$divisionBChampionsIds);
        do {
            $winnersIds = $this->playSemiFinal($winnersIds);
        } while (count($winnersIds) > 2);
        $winnersIds = $this->playFinal($winnersIds);
    }

    private function playFinal($teamsIds) {
        $teamsIdsHalf1 = array_slice($teamsIds, 0, count($teamsIds)/2);
        $teamsIdsHalf2 = array_slice($teamsIds, count($teamsIds)/2);
        $winnersIds = [];
        while ($team1Id = array_pop($teamsIdsHalf1)) {
            $team2Id = array_pop($teamsIdsHalf2);
            $team1 = Team::find($team1Id);
            $team2 = Team::find($team2Id);
            $whoWins = 0;
            do {
                $whoWins = $this->playOneGame($team1, $team2, 'F');
            } while($whoWins == 0);
            if ($whoWins == 1) {
                $winnersIds[] = $team1->team_id;
            } else {
                $winnersIds[] = $team2->team_id;
            }
        }
        return $winnersIds;
    }


    private function playSemiFinal($teamsIds) {
        $teamsIdsHalf1 = array_slice($teamsIds, 0, count($teamsIds)/2);
        $teamsIdsHalf2 = array_slice($teamsIds, count($teamsIds)/2);
        $winnersIds = [];
        while ($team1Id = array_pop($teamsIdsHalf1)) {
            $team2Id = array_pop($teamsIdsHalf2);
            $team1 = Team::find($team1Id);
            $team2 = Team::find($team2Id);
            $whoWins = 0;
            do {
                $whoWins = $this->playOneGame($team1, $team2, 'S');
            } while($whoWins == 0);
            if ($whoWins == 1) {
                $winnersIds[] = $team1->team_id;
            } else {
                $winnersIds[] = $team2->team_id;
            }
        }
        return $winnersIds;
    }

    private function playGamesInOneDivision($division)
    {
        $divTeams = Team::where('division', $division)->orderBy('team_id')->get();

        $teamPoints = [];
        foreach ($divTeams as $team) {
            $teamPoints["{$team->team_id}"] = 0;
        }

        foreach ($divTeams as $team1) {
            foreach ($divTeams as $team2) {
                if ($team1->team_id >= $team2->team_id) {
                    continue;
                }
                $whoWins = $this->playOneGame($team1, $team2, $division);
                if ($whoWins == 0) { //no one win
                    $teamPoints["{$team1->team_id}"] += 1;
                    $teamPoints["{$team2->team_id}"] += 1;
                } else if ($whoWins == 1) { // first team win
                    $teamPoints["{$team1->team_id}"] += 3;
                } else { // second team win
                    $teamPoints["{$team2->team_id}"] += 3;
                }
            }
        }
        $teamPoints2 = [];
        foreach ($teamPoints as $k => $v) {
            $teamPoints2[] = ["team" => $k, "points" => $v];
        }

        usort($teamPoints2, function($a, $b) {
            if ($a["points"] == $b["points"]) return 0;
            return ($a["points"] > $b["points"]) ? -1 : 1;
        });
        $teamIdsToSemiFinal = [];
        $i = 0;
        foreach ($teamPoints2 as $teamScores) {
            $teamIdsToSemiFinal[] = $teamScores["team"];
            if (++$i >= self::teamsToSemiFinal) break;
        }
        return $teamIdsToSemiFinal;
    }

    private function playOneGame(Team $team1, Team $team2, $division) {
        $game = new Game;
        $game->division = $division;
        $game->team1_id = $team1->team_id;
        $game->team2_id = $team2->team_id;
        $game->scores1 = rand(0,5);
        $game->scores2 = rand(0,5);
        $result = 0; // no one wins
        if ($game->scores1 > $game->scores2) {
            $game->winner_team_id = $game->team1_id;
            $result = 1; // first team wins
        } else if ($game->scores2 > $game->scores1) {
            $game->winner_team_id = $game->team2_id;
            $result = 2; // second team wins
        }
        $game->save();
        return $result;
    }

}