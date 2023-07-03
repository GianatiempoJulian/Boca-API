<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = Player::all();
        $playerArray = [];

        foreach($players as $player){
            $playerArray[]= [
                'id' => $player->id,
                'name' => $player->name,
                'lastname' => $player->lastname,
                'goals' => $player->goals,
                'assists' => $player->assists,
                'cleansheets' => $player->cleansheets,
                'yellowCards' => $player->yellowCards,
                'redCards' => $player->redCards,
                'position' => $player->position,
                'trophies' => $player->trophies,
                'wins' => $player->wins,
                'draws'=>$player->draws,
                'loses'=>$player->loses,
                'image'=>$player->image
            ];
        };

        return response()->json($playerArray);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $player = new Player();
        $player->name = $request->name;
        $player->lastname = $request->lastname;
        $player->goals = $request->goals;
        $player->assists = $request->assists;
        $player->cleansheets = $request->cleansheets;
        $player->yellowCards = $request->yellowCards;
        $player->redCards = $request->redCards;
        $player->position = $request->position;
        $player->trophies = $request->trophies;
        $player->wins = $request->wins;
        $player->draws = $request->draws;
        $player->loses = $request->loses;
        $player->image = $request->image;
        $player->save();

        $information = [
            'message' => 'Player created successfully',
            'player' => $player
        ];

        return response()->json($information);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        $information = [
            "player" => $player,
            "players" => $player->players
        ];
        return response()->json($information);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Player $player)
    {
        $player->name = $request->name;
        $player->lastname = $request->lastname;
        $player->goals = $request->goals;
        $player->assists = $request->assists;
        $player->cleansheets = $request->cleansheets;
        $player->yellowCards = $request->yellowCards;
        $player->redCards = $request->redCards;
        $player->position = $request->position;
        $player->trophies = $request->trophies;
        $player->wins = $request->wins;
        $player->draws = $request->draws;
        $player->loses = $request->loses;
        $player->image = $request->image;
        $player->save();

        $information = [
            'message' => 'Player updated successfully',
            'player' => $player
        ];

        return response()->json($information);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        $player->delete();

        $information = [
            'message' => 'Player deleted successfully',
            'player' => $player
        ];

        return response()->json($information);
    }

    public function attachGame(Request $request){

        $player = Player::find($request->playerId);
      

        if ($player->games == NULL || ! $player->games->contains($request->gameId)) {
            $player->games()->attach($request->gameId);
            $information = [
                'message' => 'Game attached successfully',
                'player' => $player
            ];
        
            return response()->json($information);
        }else{
            return response()->json('This player already is in this game!');
        }
       
    
    }

    public function detachGame(Request $request){

        $player = Player::find($request->playerId);
        $player->games()->detach($request->gameId);

        $information = [
            'message' => 'Game detached successfully',
            'player' => $player
        ];
    
        return response()->json($information);
    
    }

    public function games(Request $request){
        $player = Player::find($request->playerId);
        $games = $player->games;

        $information = [
            'message' => 'Games fetched successfully',
            'games' => $games
        ];

        return response()->json($information);
    }
}
