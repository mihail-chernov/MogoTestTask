<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TeamController@index');
Route::post('team/add', 'TeamController@addTeam');
Route::delete('team/remove', 'TeamController@removeTeams');
Route::put('team/moveAtoB', 'TeamController@moveAtoB');
Route::put('team/moveBtoA', 'TeamController@moveBtoA');
Route::get('games', 'GameController@index');
Route::post('games/play', 'GameController@generateGames');



/*
Route::get('/', function () {
    return view('teams');
});
*/
