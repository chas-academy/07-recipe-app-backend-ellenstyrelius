<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'label', 'image', 'url', 'ingredientLines', 'yield', 'healthLabels', 'dietLabels'
    ];

    public static function decodeJsonStrings($recipe)
    {
        $recipe->ingredientLines = json_decode($recipe->ingredientLines);
        $recipe->dietLabels = json_decode($recipe->dietLabels);
        $recipe->healthLabels = json_decode($recipe->healthLabels);
        return $recipe;
    }

}
