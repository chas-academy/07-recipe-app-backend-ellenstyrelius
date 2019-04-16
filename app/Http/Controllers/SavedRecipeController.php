<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SavedRecipe;

class SavedRecipeController extends Controller
{
    public function index()
    {
        return SavedRecipe::all();
    }

    public function store(Request $request)
    {
        return SavedRecipe::create($request->all());
    }

    public function destroy($savedRecipe)
    {
        SavedRecipe::find($savedRecipe)->delete();
        return 204;
        // return redirect('/saved-recipes');
    }

    public function destroyAll() {
        SavedRecipe::whereNotNull('id')->delete();
        return 204;
        // return redirect('/saved-recipes');
    }
}
