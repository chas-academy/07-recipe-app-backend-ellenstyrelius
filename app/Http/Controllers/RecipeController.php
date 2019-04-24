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

    public function filter(Request $request)
    {        
        $input = $request->query('q');
        if (str_word_count($input) > 1) {
        // if ($request->has('q')) {
            // $search = preg_split('/[\s,]+/', $request->query('q'));
            $search = preg_split('/[\s,]+/', $input);
            // if (count($search) > 1) {
            foreach ($search as $searchWord) {
                $recipes = Recipe::where('label', 'like', '%' . $searchWord . '%')
                    ->where('ingredientLines', 'like', '%' . $searchWord . '%')
                    ->orderBy('label', 'asc')
                    ->get();
                foreach ($recipes as $recipe) {
                    Recipe::decodeJsonStrings($recipe);
                }
                return $recipes;
            }
            // } else {
                // $recipes = Recipe::where('label', 'like', '%'.$search.'%')
                //     ->orWhere('ingredientLines', 'like', '%'.$search.'%')
                //     ->orderBy('label', 'asc')
                //     ->get();
                // foreach ($recipes as $recipe) {
                //     Recipe::decodeJsonStrings($recipe);
                // }
                // return $recipes;
            // }
        } elseif (str_word_count($input) === 1) {
            $recipes = Recipe::where('label', 'like', '%' . $input . '%')
                ->orWhere('ingredientLines', 'like', '%' . $input . '%')
                ->orderBy('label', 'asc')
                ->get();
            foreach ($recipes as $recipe) {
                Recipe::decodeJsonStrings($recipe);
            }
            return $recipes;
        }
    }

    public function show($recipe) 
    {
        $recipeData = Recipe::find($recipe);
        $recipeDecoded = Recipe::decodeJsonStrings($recipeData);
        return $recipeDecoded;
    }
}
