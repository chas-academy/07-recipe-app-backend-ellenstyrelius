<?php

use Illuminate\Http\Request;

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

Route::get('recipes', function () {
    return Recipe::all();
});


Route::get('recipes/{id}', function ($id) {
    return Recipe::find($id);
});

Route::get('saved-recipes', function () {
    return SavedRecipe::all();
});

Route::post('saved-recipes', function (Request $request) {
    return SavedRecipe::create($request->all());
});

// Route::get('saved-recipes/{id}', function ($id) {
//     return SavedRecipe::find($id);
// });

Route::delete('saved-recipes/{id}', function ($id) {
    SavedRecipe::find($id)->delete();
    return 204;
});