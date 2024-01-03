<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//*====  USER ROUTES  ====*//
Route::post('/register', [AuthController::class, 'register']); //Store one season
Route::post('/login', [AuthController::class,'login']);

//*====  SEASON ROUTES  ====*//
Route::get('/seasons', [SeasonController::class, 'index']); //Retrieve all the seasons
Route::get('/seasons/{season}', [SeasonController::class, 'show']); //Retrieve one season

//*====  COMPETITION ROUTES  ====*//
Route::get('/competitions', [CompetitionController::class, 'index']); //Retrieve all the competitions
Route::get('/competitions/{competition}', [CompetitionController::class, 'show']); //Retrieve one competition

//*====  GAMES ROUTES  ====*
Route::get('/games', [GameController::class, 'index']); //Retrieve all the games
Route::get('/games/{game}', [GameController::class, 'show']); //Retrieve one game

//*====  TEAMS ROUTES  ====*
Route::get('/teams', [TeamController::class, 'index']); //Retrieve all the team
Route::get('/teams/{team}', [TeamController::class, 'show']); //Retrieve one team

//*====  PLAYERS ROUTES  ====*
Route::get('/players', [PlayerController::class, 'index']); //Retrieve all the player
Route::get('/players/{player}', [PlayerController::class, 'show']); //Retrieve one player

//*====  TEAMS <-> GAMES ROUTES  ====*//
Route::post('/teams/{team}/games', [TeamController::class, 'games']); //Fetch all the games of this team
Route::post('/games/{game}/teams', [GameController::class, 'teams']); //Fetch all the teams of this game

//*====  PLAYERS <-> GAMES ROUTES  ====*//
Route::post('/players/{player}/games', [PlayerController::class, 'players']); //Fetch all the games of this player
Route::post('/games/{game}/players', [GameController::class, 'players']); //Fetch all the players of this game

//*====  SEASON <-> COMPETITION ROUTES  ====*//
Route::post('/seasons/{season}/competitions', [SeasonController::class, 'competitions']); //Fetch all the competitions of this season
Route::post('/competitions/{competition}/seasons', [CompetitionController::class, 'seasons']); //Fetch all the seasons of this competition
Route::get('/competitions/{competition}/games', [CompetitionController::class, 'games']); //Fetch all the games of this competition



//! RUTAS CONTROLADAS !//A
Route::group(['middleware' => 'auth:sanctum'], function () {

    //*====  USER ROUTES  ====*//
    Route::get('/logout',[AuthController::class,'logout']);

    //*====  SEASON ROUTES  ====*//
    Route::post('/seasons', [SeasonController::class, 'store']); //Store one season
    Route::put('/seasons/{season}', [SeasonController::class, 'update']); //Update one season
    Route::delete('/seasons/{season}', [SeasonController::class, 'destroy']); //Delete one season

    //*====  COMPETITION ROUTES  ====*//
    Route::post('/competitions', [CompetitionController::class, 'store']); //Store one competition
    Route::put('/competitions/{competition}', [CompetitionController::class, 'update']); //Update one competition
    Route::delete('/competitions/{competition}', [CompetitionController::class, 'destroy']); //Delete one competition
   
    //*====  GAMES ROUTES  ====*
    Route::post('/games', [GameController::class, 'store']); //Store one game
    Route::put('/games/{game}', [GameController::class, 'update']); //Update one game
    Route::delete('/games/{game}', [GameController::class, 'destroy']); //Delete one game
   
    //*====  TEAMS ROUTES  ====*
    Route::post('/teams', [TeamController::class, 'store']); //Store one team
    Route::put('/teams/{team}', [TeamController::class, 'update']); //Update one team
    Route::delete('/teams/{team}', [TeamController::class, 'destroy']); //Delete one team
    
    //*====  PLAYERS ROUTES  ====*
    Route::post('/players', [PlayerController::class, 'store']); //Store one player
    Route::put('/players/{player}', [PlayerController::class, 'update']); //Update one player
    Route::delete('/players/{player}', [PlayerController::class, 'destroy']); //Delete one player
    
    //*====  TEAMS <-> GAMES ROUTES  ====*//
    Route::post('/teams/games', [TeamController::class, 'attachGame']); //Attach one game to a one team
    Route::post('/teams/games/detach', [TeamController::class, 'detachGame']); //Detach one game to a one team

    Route::post('/games/teams', [GameController::class, 'attachTeam']); //Attach one team to a one game
    Route::post('/games/teams/detach', [GameController::class, 'detachTeam']); //Detach one team to a one game

    //*====  PLAYERS <-> GAMES ROUTES  ====*//
    Route::post('/players/games', [PlayerController::class, 'attachGame']); //Attach one game to a one player
    Route::post('/players/games/detach', [PlayerController::class, 'detachGame']); //Detach one game to a one player

    Route::post('/games/players', [GameController::class, 'attachPlayer']); //Attach one player to a one game
    Route::post('/games/players/detach', [GameController::class, 'detachPlayer']); //Detach one player to a one game

    //*====  SEASON <-> COMPETITION ROUTES  ====*//

    Route::post('/competitions/seasons', [CompetitionController::class, 'attachSeason']); //Attach one season to a one competition  
    Route::post('/competitions/seasons/detach', [CompetitionController::class, 'detachSeason']); //Detach one season to a one competition

    Route::post('/seasons/competitions', [SeasonController::class, 'attachCompetition']); //Attach one competition to a one season  
    Route::post('/seasons/competitions/detach', [SeasonController::class, 'detachCompetition']); //Detach one season to a one competition

    //*====  COMPETITION <-> GAMES ROUTES  ====*//
    Route::post('/competitions/games', [CompetitionController::class, 'attachGame']); //Attach one game to a one competition  
    Route::post('/competitions/games/detach', [CompetitionController::class, 'detachGame']); //Detach one game to a one competition

});


