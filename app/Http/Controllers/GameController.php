<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
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
                'goalsBoca' => $game->goalsBoca,
                'goalsTeamRival' => $game->goalsTeamRival,
                'gameDate' => $game->gameDate,
                'competition' => $game->competition,
                'players' => $game->players,
                'teams' => $game->teams
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
        $game->goalsBoca = $request->goalsBoca;
        $game->goalsTeamRival = $request->goalsTeamRival;
        $game->gameDate = $request->gameDate;
        $game->competition_id = $request->competition_id;
      
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
            "players" => $game->players,
            "teams" => $game->teams
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
        $game->goalsBoca = $request->goalsBoca;
        $game->goalsTeamRival = $request->goalsTeamRival;
        $game->gameDate = $request->gameDate;
        $game->competition_id = $request->competition_id;
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

        $game = Game::find($request->game_id);
        $player = Player::find($request->player_id);
       
        if ($game->players == NULL || ! $game->players->contains($request->player_id)) {

            $player->goals = $player->goals + $request->goals_today;
            $player->assists = $player->assists + $request->assists_today;
            $player->cleansheets = $player->cleansheets + $request->cleansheets_today;
            $player->redcards = $player->redcards + $request->redcard_today;
            $player->goals_today = $request->goals_today;
            $player->assists_today = $request->assists_today;
            $player->cleansheets_today = $request->cleansheets_today;
            $player->redcard_today = $request->redcard_today;
            $player->save();
            
            $game->players()->attach($request->player_id);
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

        $game = Game::find($request->game_id);
        $game->players()->detach($request->player_id);

        $information = [
            'message' => 'Player detached successfully',
            'game' => $game
        ];
    
        return response()->json($information);
    
    }

    public function players(Request $request){
        $game = Game::find($request->game_id);
        $players = $game->players;

        $information = [
            'message' => 'Players fetched successfully',
            'players' => $players
        ];

        return response()->json($information);
    }

    public function attachTeam(Request $request){

        $game = Game::find($request->game_id);
    
        if ($game->teams == NULL || ! $game->teams->contains($request->team_id)) {

            $game->teams()->attach($request->team_id);
            $information = [
                'message' => 'Team attached successfully',
                'game' => $game
            ];
            return response()->json($information);
        }else{
            return response()->json('This game already has this team!');
        }
    }

    public function detachTeam(Request $request){

        $game = Game::find($request->game_id);
        $game->teams()->detach($request->team_id);

        $information = [
            'message' => 'Team detached successfully',
            'game' => $game
        ];
    
        return response()->json($information);
    
    }

    public function teams(Request $request){
        $game = Game::find($request->game_id);
        $teams = $game->teams;

        $information = [
            'message' => 'Teams fetched successfully',
            'teams' => $teams
        ];

        return response()->json($information);
    }
}
