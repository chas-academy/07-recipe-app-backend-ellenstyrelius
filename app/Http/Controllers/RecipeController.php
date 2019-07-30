<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        foreach ($recipes as $recipe) {
            Recipe::decodeJsonStrings($recipe);
        } 
        return $recipes;
    }

    public function show($recipe) 
    {
        $recipeData = Recipe::find($recipe);
        $recipeDecoded = Recipe::decodeJsonStrings($recipeData);
        return $recipeDecoded;
    }

    public function filter(Request $request)
    {        
        $input = $request->query('q');
        $diet = $request->query('diet');
        $recipes = array();
        $nrOfInputWords = null;
        $inputRecipeIds = array();
        $nrOfDietWords = null;
        $dietRecipeIds = array();
        $recipeIds = array();
        $filteredRecipeIds = array();
    
        if ($input) {
            $inputSearch = explode(' ', $input);
            $nrOfInputWords = count($inputSearch);
            foreach ($inputSearch as $searchWord) {
                $inputRecipes = Recipe::where('label', 'like', '%' . $searchWord . '%')
                    ->orWhere('ingredientLines', 'like', '%' . $searchWord . '%')
                    ->get();
                foreach ($inputRecipes as $inputRecipe) {
                    $inputRecipeIds[] = $inputRecipe->id;
                }
            }
            foreach ($inputRecipeIds as $id) {
                $recipeIds[] = $id;
            }
        }

        if ($diet) {
            $dietSearch = explode(',', $diet);
            $nrOfDietWords = count($dietSearch);
            foreach ($dietSearch as $searchWord) {
                $dietRecipes = Recipe::where('healthLabels', 'like', '%' . $searchWord . '%')
                    ->orWhere('dietLabels', 'like', '%' . $searchWord . '%')
                    ->get();
                foreach ($dietRecipes as $dietRecipe) {
                    $dietRecipeIds[] = $dietRecipe->id;
                }
            }
            foreach ($dietRecipeIds as $id) {
                $recipeIds[] = $id;
            }
        }

        $occurrenceOfIds = array_count_values($recipeIds);
        $nrOfWords = $nrOfInputWords + $nrOfDietWords;
        foreach ($occurrenceOfIds as $key => $value) {
            if ($value === $nrOfWords) {
                $filteredRecipeIds[] = $key;
            }
        }
        foreach ($filteredRecipeIds as $id) {
            $filteredRecipes = Recipe::where('id', $id)
                ->orderBy('label', 'asc')
                ->get();
            foreach ($filteredRecipes as $recipe) {
                Recipe::decodeJsonStrings($recipe);
                $recipes[] = $recipe;
            }
        }
        return $recipes;
    }
}
