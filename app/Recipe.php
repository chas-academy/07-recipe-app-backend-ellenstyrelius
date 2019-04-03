<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'label', 'image', 'url', 'ingredientLines', 'yield', 'healthLabels', 'dietLabels'
    ];

}
