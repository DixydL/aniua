<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('anime/relative', 'API\AnimeController@relative');
Route::resource('anime', 'API\AnimeController');
Route::resource('file', 'API\FileController');
Route::resource('episode', 'API\EpisodeController');
Route::resource('anime.episode', 'API\AnimeEpisodeController');
