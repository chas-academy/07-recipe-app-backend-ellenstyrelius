<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Kernel;

use App\Recipe;
use App\SavedRecipe;

/*
|These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
*/

Route::get('recipes', 'RecipeController@index');
Route::get('recipes/search', 'RecipeController@filter');
Route::get('recipes/{recipe}', 'RecipeController@show');

/* ---- routes that require authentication ---- */
Route::group(
    ['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        Route::group(
            ['middleware' => 'auth:api'], function () {
                Route::get('logout', 'AuthController@logout');
                Route::get('user', 'AuthController@user');
                Route::get('saved-recipes', 'SavedRecipeController@index');
                Route::post('saved-recipes', 'SavedRecipeController@store');
                Route::delete('saved-recipes/{recipeId}', 'SavedRecipeController@destroy');
                Route::delete('saved-recipes', 'SavedRecipeController@destroyAll');
            }
        );
    }
);