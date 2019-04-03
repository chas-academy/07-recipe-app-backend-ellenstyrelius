<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedRecipe extends Model
{
    protected $fillable = ['label', 'image'];
}
