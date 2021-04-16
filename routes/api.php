<?php

use Illuminate\Http\Request;
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
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('/searchLots', 'MapController@searchLots');
// Route::get('/polygon', 'MapController@drawPolygon');
// Route::post('/filter', 'MapController@filter');



Auth::routes();
Route::group(['middleware' => 'auth'], function(){
// Route::middleware('auth:api')->group(function(){
        Route::get('/searchLots', 'MapController@searchLots');
        Route::get('/polygon', 'MapController@drawPolygon');
        Route::post('/filter', 'MapController@filter');
});