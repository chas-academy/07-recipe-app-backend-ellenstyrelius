<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SavedRecipe;

class SavedRecipeController extends Controller
{
    public function index(Request $request)
    {
        return SavedRecipe::where('user_id', $request->user()->id)
        ->get();
    }

    public function store(Request $request)
    {
        $alreadySavedRecipe = SavedRecipe::where('user_id', $request->user()->id)
            ->where('recipe_id', $request->id)
            ->get();
        if (count($alreadySavedRecipe) < 1) {
            $savedRecipe = new SavedRecipe(
                ['label' => $request->label,
                'image' => $request->image,
                'recipe_id' => $request->id,
                'user_id' => $request->user()->id]
            );
            $savedRecipe->save();
            return response()->json(
                ['message' => 'Recipe saved!']
            );
        } elseif (count($alreadySavedRecipe) > 0) {
            return response()->json(
                ['message' => 'Recipe already saved']
            );
        }
    }

    public function destroy($recipeId, Request $request)
    {
        SavedRecipe::where('user_id', $request->user()->id)
            ->where('recipe_id', $recipeId)
            ->delete();
        return 204;
        // return redirect('/saved-recipes');
    }

    public function destroyAll(Request $request) 
    {
        SavedRecipe::where('user_id', $request->user()->id)
            ->whereNotNull('id')
            ->delete();
        return 204;
        // return redirect('/saved-recipes');
    }
}
