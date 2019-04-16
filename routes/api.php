<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Kernel;

use App\Recipe;
use App\SavedRecipe;

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

/* ------ auth routes that may be needed????? ------ */
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout');
// Route::post('register', 'Auth\RegisterController@register');

Route::get('/recipes', 'RecipeController@index');
Route::get('recipes/{recipe}', 'RecipeController@show');

/* ------------ routes specific to users!! ------------ */
/* ------------ has to be modified later?? ------------ */
/* ------------ will need jwt and stuffz?? ------------ */
// Route::group(['middleware' => 'auth:api'], function () {
Route::get('saved-recipes', 'SavedRecipeController@index');

Route::post('saved-recipes', 'SavedRecipeController@store');

Route::delete('saved-recipes/{savedRecipe}', 'SavedRecipeController@destroy');

Route::delete('saved-recipes', 'SavedRecipeController@destroyAll');
// });