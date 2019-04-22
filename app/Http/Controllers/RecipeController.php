<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        foreach ($recipes as $recipe) {
            Recipe::decodeJson($recipe);
        } 
        return $recipes;
    }

    public function filter($input)
    {        
        $recipes = Recipe::where('label', 'like', '%'.$input.'%')
            ->orWhere('ingredientLines', 'like', '%'.$input.'%')
            ->get();
        foreach ($recipes as $recipe) {
            Recipe::decodeJson($recipe);
        } 
        return $recipes;
    }

    public function show($recipe) 
    {
        $recipeData = Recipe::find($recipe);
        $recipeDecoded = Recipe::decodeJson($recipeData);
        return $recipeDecoded;
    }
}
