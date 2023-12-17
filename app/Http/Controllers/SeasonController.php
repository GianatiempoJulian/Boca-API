<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasons = Season::all();
        $seasonArray = [];

        foreach($seasons as $season){
            $seasonArray[]= [
                'id' => $season->id,
                'year' => $season->year,
                'name' => $season->name,
                'competitions' => $season->competitions
            ];
        };

        krsort($seasonArray);

        return response()->json($seasonArray);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $season = new Season();
        $season->year = $request->year;
        $season->name = $request->name;
        $season->save();

        $information = [
            'message' => 'Season created successfully',
            'season' => $season
        ];

        return response()->json($information);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season)
    {
        $information = [
            "season" => $season,
            "competitions" => $season->competitions
        ];
        return response()->json($information);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Season $season)
    {
        $season->year = $request->year;
        $season->name = $request->name;
        $season->save();

        $information = [
            'message' => 'Season updated successfully',
            'season' => $season
        ];

        return response()->json($information);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season)
    {
        $season->delete();

        $information = [
            'message' => 'Season deleted successfully',
            'season' => $season
        ];

        return response()->json($information);
    }

    public function attachCompetition(Request $request){

        $season = Season::find($request->season_id);

        if ($season->competitions == NULL || ! $season->competitions->contains($request->competition_id)) {            
            $season->competitions()->attach($request->competition_id);
            $information = [
                'message' => 'Competititon attached successfully',
                'season' => $season
            ];
            return response()->json($information);
        }else{
            return response()->json('This season already has this player!');
        }
    }

    public function competitions(Request $request){
        $season = Season::find($request->season_id);
        $competitions = $season->competitions;
        return response()->json($competitions);
    }
    
}
