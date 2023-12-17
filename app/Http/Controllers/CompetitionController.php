<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competitions = Competition::all();
        $competitionArray = [];

        foreach($competitions as $competition){
            $competitionArray[]= [
                'id' => $competition->id,
                'name' => $competition->name,
                'image' => $competition->image,
                'seasons' => $competition->seasons,
                'games' => $competition->games
            ];
        };

        return response()->json($competitionArray);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $competition = new Competition();
        $competition->name = $request->name;
        $competition->image = $request->image;
        $competition->save();

        $information = [
            'message' => 'Competition created successfully',
            'competition' => $competition
        ];

        return response()->json($information);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function show(Competition $competition)
    {
        $information = [
            "competition" => $competition,
            "season" => $competition->seasons,
            "games" => $competition->games
        ];
        return response()->json($information);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Competition $competition)
    {
        $competition->name = $request->name;
        $competition->image = $request->image;
        $competition->season_id = $request->season_id;
        $competition->save();

        $information = [
            'message' => 'Competition updated successfully',
            'competition' => $competition
        ];

        return response()->json($information);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Competition  $competition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Competition $competition)
    {
        $competition->delete();

        $information = [
            'message' => 'Competition deleted successfully',
            'competition' => $competition
        ];

        return response()->json($information);
    }


    public function attachSeason(Request $request){

        $competition = Competition::find($request->competition_id);
        if ($competition->seasons == NULL || ! $competition->seasons->contains($request->season_id)) {
            $competition->seasons()->attach($request->season_id);
            $information = [
                'message' => 'Season attached successfully',
                'competition' => $competition
            ];
        
            return response()->json($information);
        }else{
            return response()->json('This competition already is in this season!');
        } 
    }

    public function detachSeason(Request $request){

        $competition = Competition::find($request->competition_id);
        $competition->seasons()->detach($request->season_id);

        $information = [
            'message' => 'Season detached successfully',
            'competition' => $competition
        ];

        return response()->json($information);
    }

    public function attachGame(Request $request){

        $competition = Competition::find($request->competition);

        if ($competition->games == NULL || ! $competition->games->contains($request->game_id)) {
            $competition->games()->attach($request->game_id);

            $information = [
                'message' => 'Game attached successfully',
                'competition' => $competition
            ];
    
            return response()->json($information);
        }
        else{
            return response()->json('This competition already has this game!');
        }
    }

    public function detachGame(Request $request){

        $competition = Competition::find($request->competition);
        $competition->games()->detach($request->game_id);

        $information = [
            'message' => 'Game detached successfully',
            'competition' => $competition
        ];

        return response()->json($information);
    }

    public function games(Competition $competition){
        $findOne = Competition::find($competition->id);
        $games = $findOne->games;
        return response()->json($games);
    }

    public function seasons(Request $request){
        $competition = Competition::find($request->competition);
        $seasons = $competition->seasons;

        $information = [
            'message' => 'Seasons fetched successfully',
            'seasons' => $seasons
        ];

        return response()->json($information);
    }

}
