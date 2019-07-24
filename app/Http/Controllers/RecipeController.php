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
    
        if ($input) {

            if (str_word_count($input) > 1) {
                $search = explode(' ', $input);
                foreach ($search as $searchWord) {
                    $inputRecipes = Recipe::where('label', 'like', '%' . $searchWord . '%')
                        ->where('ingredientLines', 'like', '%' . $searchWord . '%')
                        ->orderBy('label', 'asc')
                        ->get();
                    foreach ($inputRecipes as $recipe) {
                        Recipe::decodeJsonStrings($recipe);
                        $recipes[] = $recipe;
                    }
                }
            } 
            if (str_word_count($input) === 1) {
                $inputRecipes = Recipe::where('label', 'like', '%' . $input . '%')
                    ->orWhere('ingredientLines', 'like', '%' . $input . '%')
                    ->orderBy('label', 'asc')
                    ->get();
                foreach ($inputRecipes as $recipe) {
                    Recipe::decodeJsonStrings($recipe);
                    $recipes[] = $recipe;
                }
            }
        }

        if ($diet) {
            $dietSearch = explode(',', $diet);

            // push the results from both foreach into own arrays and compare them? 
            // or just compare them as strings? 
            // this to only get recipes that has all of the labels
            // then push the result into recipes array

            foreach ($dietSearch as $healthLabel) {
                $healthRecipes = Recipe::where('healthLabels', 'like', '%' . $healthLabel . '%')
                    ->orderBy('label', 'asc')
                    ->get();
                foreach ($healthRecipes as $recipe) {
                    Recipe::decodeJsonStrings($recipe);
                    $recipes[] = $recipe;
                }  
            }

            foreach ($dietSearch as $dietLabel) {
                $dietRecipes = Recipe::where('dietLabels', 'like', '%' . $dietLabel . '%')
                    ->orderBy('label', 'asc')
                    ->get();
                foreach ($dietRecipes as $recipe) {
                    Recipe::decodeJsonStrings($recipe);
                    $recipes[] = $recipe;
                }
            }
        }

        return $recipes;
    }
}
