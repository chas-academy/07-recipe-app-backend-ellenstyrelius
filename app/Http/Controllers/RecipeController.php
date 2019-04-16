<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        return Recipe::all();
    }

    public function show($recipe) 
    {
        return Recipe::find($recipe);
    }
}
