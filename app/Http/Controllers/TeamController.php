<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        $teamsArray = [];

        foreach($teams as $team){
            $teamsArray[]= [
                'id' => $team->id,
                'name' => $team->name,
                'image' => $team->image
            ];
        };

        return response()->json($teamsArray);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = new Team();
        $team->name = $request->name;
        $team->image = $request->image;
        $team->save();

        $information = [
            'message' => 'team created successfully',
            'team' => $team
        ];

        return response()->json($information);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        $information = [
            "team" => $team,
            "games" => $team->games
        ];
        return response()->json($information);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $team->name = $request->name;
        $team->image = $request->image;
        $team->save();

        $information = [
            'message' => 'team updated successfully',
            'team' => $team
        ];

        return response()->json($information);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();

        $information = [
            'message' => 'team deleted successfully',
            'team' => $team
        ];

        return response()->json($information);
    }

    public function attachGame(Request $request){

        $team = Team::find($request->team_id);
      
        if ($team->games == NULL || ! $team->games->contains($request->game_id)) {
            $team->games()->attach($request->game_id);
            $information = [
                'message' => 'Game attached successfully',
                'team' => $team
            ];
        
            return response()->json($information);
        }else{
            return response()->json('This team already is in this game!');
        }
       
    
    }

    public function detachGame(Request $request){

        $team = Team::find($request->team_id);
        $team->games()->detach($request->game_id);

        $information = [
            'message' => 'Game detached successfully',
            'team' => $team
        ];
    
        return response()->json($information);
    
    }

    public function games(Request $request){
        $team = Team::find($request->team_id);
        $games = $team->games;

        $information = [
            'message' => 'Games fetched successfully',
            'games' => $games
        ];

        return response()->json($information);
    }
}
