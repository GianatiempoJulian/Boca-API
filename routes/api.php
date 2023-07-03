<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\GameController;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


//*====  SEASON ROUTES  ====*//
Route::post('/seasons', [SeasonController::class, 'store']); //Store one season
Route::put('/seasons/{season}', [SeasonController::class, 'update']); //Update one season
Route::delete('/seasons/{season}', [SeasonController::class, 'destroy']); //Delete one season
Route::get('/seasons', [SeasonController::class, 'index']); //Retrieve all the seasons
Route::get('/seasons/{season}', [SeasonController::class, 'show']); //Retrieve one season

//*====  COMPETITION ROUTES  ====*//
Route::post('/competitions', [CompetitionController::class, 'store']); //Store one competition
Route::put('/competitions/{competition}', [CompetitionController::class, 'update']); //Update one competition
Route::delete('/competitions/{competition}', [CompetitionController::class, 'destroy']); //Delete one competition
Route::get('/competitions', [CompetitionController::class, 'index']); //Retrieve all the competitions
Route::get('/competitions/{competition}', [CompetitionController::class, 'show']); //Retrieve one competition

//*====  GAMES ROUTES  ====*
Route::post('/games', [GameController::class, 'store']); //Store one game
Route::put('/games/{game}', [GameController::class, 'update']); //Update one game
Route::delete('/games/{game}', [GameController::class, 'destroy']); //Delete one game
Route::get('/games', [GameController::class, 'index']); //Retrieve all the games
Route::get('/games/{game}', [GameController::class, 'show']); //Retrieve one game

//*====  PLAYERS ROUTES  ====*
Route::post('/players', [PlayerController::class, 'store']); //Store one player
Route::put('/players/{player}', [PlayerController::class, 'update']); //Update one player
Route::delete('/players/{player}', [PlayerController::class, 'destroy']); //Delete one player
Route::get('/players', [PlayerController::class, 'index']); //Retrieve all the player
Route::get('/players/{player}', [PlayerController::class, 'show']); //Retrieve one player

//*====  PLAYERS <-> GAMES ROUTES  ====*//
Route::post('/players/games', [PlayerController::class, 'attachGame']); //Attach one game to a one player
Route::post('/players/games/detach', [PlayerController::class, 'detachGame']); //Detach one game to a one player
Route::post('/players/{player}/games', [PlayerController::class, 'players']); //Fetch all the games of this player

Route::post('/games/players', [GameController::class, 'attachPlayer']); //Attach one player to a one game
Route::post('/games/players/detach', [GameController::class, 'detachPlayer']); //Detach one player to a one game
Route::post('/games/{game}/players', [GameController::class, 'players']); //Fetch all the players of this game

//*====  SEASON <-> COMPETITION ROUTES  ====*//
Route::post('/seasons/{season}/competitions', [SeasonController::class, 'competitions']); //Fetch all the competitions of this season

Route::post('/competitions/seasons', [CompetitionController::class, 'attachSeason']); //Attach one season to a one competition  
Route::post('/competitions/seasons/detach', [CompetitionController::class, 'detachSeason']); //Detach one season to a one competition

//*====  COMPETITION <-> GAMES ROUTES  ====*//
Route::post('/competitions/games', [CompetitionController::class, 'attachGame']); //Attach one game to a one competition  
Route::post('/competitions/games/detach', [CompetitionController::class, 'detachGame']); //Detach one game to a one competition

