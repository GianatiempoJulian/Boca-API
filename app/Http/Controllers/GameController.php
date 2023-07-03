<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();
        $gamesArray = [];

        foreach($games as $game){
            $gamesArray[]= [
                'id' => $game->id,
                'stadium' => $game->stadium,
                'teamHome' => $game->teamHome,
                'teamAway' => $game->teamAway,
                'teamHomeImage' => $game->teamHomeImage,
                'teamAwayImage' => $game->teamAwayImage,
                'goalsHome' => $game->goalsHome,
                'goalsAway' => $game->goalsAway,
                'gameDate' => $game->gameDate,
                'competition' => $game->competition,
                'players' => $game->players
            ];
        };

        return response()->json($gamesArray);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = new Game();
        $game->stadium = $request->stadium;
        $game->teamHome = $request->teamHome;
        $game->teamAway = $request->teamAway;
        $game->teamHomeImage = $request->teamHomeImage;
        $game->teamAwayImage = $request->teamAwayImage;
        $game->goalsHome = $request->goalsHome;
        $game->goalsAway = $request->goalsAway;
        $game->gameDate = $request->gameDate;
        $game->competitionId = $request->competitionId;
      
        $game->save();

        $information = [
            'message' => 'Game created successfully',
            'game' => $game
        ];

        return response()->json($information);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $information = [
            "game" => $game,
            "competition" => $game->competition,
            "players" => $game->players
        ];
        return response()->json($information);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $game->stadium = $request->stadium;
        $game->teamHome = $request->teamHome;
        $game->teamAway = $request->teamAway;
        $game->teamHomeImage = $request->teamHomeImage;
        $game->teamAwayImage = $request->teamAwayImage;
        $game->goalsHome = $request->goalsHome;
        $game->goalsAway = $request->goalsAway;
        $game->gameDate = $request->gameDate;
        $game->competitionId = $request->competitionId;
        $game->save();

        $information = [
            'message' => 'Game updated successfully',
            'game' => $game
        ];

        return response()->json($information);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $game->delete();

        $information = [
            'message' => 'Game deleted successfully',
            'game' => $game
        ];

        return response()->json($information);
    }

    public function attachPlayer(Request $request){

        $game = Game::find($request->gameId);
       
        if ($game->players == NULL || ! $game->players->contains($request->playerId)) {
            $game->players()->attach($request->playerId);
            $information = [
                'message' => 'Player attached successfully',
                'game' => $game
            ];
            return response()->json($information);
        }else{
            return response()->json('This game already has this player!');
        }
        
    
       
    
    }

    public function detachPlayer(Request $request){

        $game = Game::find($request->gameId);
        $game->players()->detach($request->playerId);

        $information = [
            'message' => 'Player detached successfully',
            'game' => $game
        ];
    
        return response()->json($information);
    
    }

    public function players(Request $request){
        $game = Game::find($request->gameId);
        $players = $game->players;

        $information = [
            'message' => 'Players fetched successfully',
            'players' => $players
        ];

        return response()->json($information);
    }
}
