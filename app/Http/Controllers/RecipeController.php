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
            $recipe->ingredientLines = json_decode($recipe->ingredientLines);
            $recipe->dietLabels = json_decode($recipe->dietLabels);
            $recipe->healthLabels = json_decode($recipe->healthLabels);

            return $recipes;
        }
        
    }

    public function show($recipe) 
    {
        $recipeData = Recipe::find($recipe);
        function decode($recipeData)
        {
            $recipeData->ingredientLines = json_decode($recipeData->ingredientLines);
            $recipeData->dietLabels = json_decode($recipeData->dietLabels);
            $recipeData->healthLabels = json_decode($recipeData->healthLabels);

            return $recipeData;
        }

        $recipeDecoded = decode($recipeData);
        return $recipeDecoded;
    }
}
