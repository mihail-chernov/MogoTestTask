<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \App\Team;
use Psy\Exception\RuntimeException;


class TeamController extends BaseController
{
    public function index() {
        $teams = Team::all();
        return view('teams', array(
            'teams' => $teams
        ));
    }

    public function addTeam(Request $request) {
        $rules = [
          'title' => 'required|max:200',
          'division' => 'required|max:1'
        ];
        $request->validate($rules);
        $team = new Team;

        if ($team->where(['title' => $request->title])->first()) {
            throw new RuntimeException("Team title must be unique.");
        }

        $team->title = $request->title;
        $team->division = $request->division;
        $team->save();
        return $team->toJson();
    }

    public function removeTeams(Request $request) {
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            Team::destroy($ids);
        }
        return response()->json(["success" => true]);
    }

    public function moveAtoB(Request $request) {
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            Team::where('team_id', $id)->update(['division' => 'B']);
        }
        return response()->json(["success" => true]);
    }

    public function moveBtoA(Request $request) {
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            Team::where('team_id', $id)->update(['division' => 'A']);
        }
        return response()->json(["success" => true]);
    }
}