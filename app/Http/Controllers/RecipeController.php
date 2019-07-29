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
        $recipesInput = array();
        $recipesHealth = array();
        $recipesDiet = array();
        $recipesHealthDiet = array();
        $dietRecipeIds = array();
        $recipeIds = array();
        $filteredRecipeIds = array();
    
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
                        $recipesInput[] = $recipe;
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
                    $recipesInput[] = $recipe;
                }
            }
        }

        //////////////////////////////////
        // hämta bara ID:n och jämför arrayer med ID!!!!
        // hämta sedan recept baserat på ID:n

        // filtrera ut de ID:n som förekommer i en array lika många gånger som antal sökord
        // eller pusha resultat-arrayer till ny array och jämföra arrayerna

        if ($diet) {
            $dietSearch = explode(',', $diet);
            $nrOfWords = count($dietSearch);
            
            if ($nrOfWords === 1) {
                $dietRecipes = Recipe::where('healthLabels', 'like', '%' . $diet . '%')
                    ->orWhere('dietLabels', 'like', '%' . $diet . '%')
                    ->get();
                foreach ($dietRecipes as $dietRecipe) {
                    $dietRecipeIds[] = $dietRecipe->id;
                }
            }

            if ($nrOfWords > 1) {
                foreach ($dietSearch as $searchWord) {
                    $dietRecipes = Recipe::where('healthLabels', 'like', '%' . $searchWord . '%')
                        ->orWhere('dietLabels', 'like', '%' . $searchWord . '%')
                        ->get();
                    foreach ($dietRecipes as $dietRecipe) {
                        $dietRecipeIds[] = $dietRecipe->id;
                    }
                }
            }

            foreach ($dietRecipeIds as $id) {
                $recipeIds[] = $id;
            }

            $occurrenceOfIds = array_count_values($recipeIds);
            
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
        }
        
        // $recipesDietCollection = collect($recipesDiet);
        // $recipesDietHealth = $recipesDietCollection->intersect($recipesHealth);
        // $recipesDietHealth->all();

        // $recipesDietHealth = array_intersect($recipesHealth, $recipesDiet);
        // $recipes = array_intersect($recipesInput, $recipesDietHealth);

        return $recipes;
    }
}
