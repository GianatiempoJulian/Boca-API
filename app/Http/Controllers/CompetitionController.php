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
                'season' => $competition->season
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
        $competition->seasonId = $request->seasonId;
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
            "season" => $competition->season,
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
        $competition->seasonId = $request->seasonId;
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

        $competition = Competition::find($request->competitionId);
        $competition->serie()->attach($request->seasonId);

        $information = [
            'message' => 'Season attached successfully',
            'competition' => $competition
        ];
    
        return response()->json($information);
    
    }

    public function detachSeason(Request $request){

        $competition = Competition::find($request->competitionId);
        $competition->serie()->detach($request->seasonId);

        $information = [
            'message' => 'Season detached successfully',
            'competition' => $competition
        ];

        return response()->json($information);
    }

    public function attachGame(Request $request){

        $competition = Competition::find($request->competitionId);

        if ($competition->games == NULL || ! $competition->games->contains($request->gameId)) {
            $competition->games()->attach($request->gameId);

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

        $competition = Competition::find($request->competitionId);
        $competition->games()->detach($request->gameId);

        $information = [
            'message' => 'Game detached successfully',
            'competition' => $competition
        ];

        return response()->json($information);
    }
}
