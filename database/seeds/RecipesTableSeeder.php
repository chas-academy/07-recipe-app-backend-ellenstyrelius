<?php

use Illuminate\Database\Seeder;

use App\Recipe;


//////////////
// importera json-filerna på ngt jävla vis???!!!
/////////////

// use Storage;

// $json = Storage::disk('local')->get('calendar_Ids.json');
// $json = json_decode($json, true);



class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipes')->delete();
        $jsonPasta = File::get('database/data/pasta.json');
        $recipesPasta = json_decode($jsonPasta);
        $jsonPizza = File::get('database/data/pizza.json');
        $recipesPizza = json_decode($jsonPizza);
        $jsonPotato = File::get('database/data/potato.json');
        $recipesPotato = json_decode($jsonPotato);

        function seedRecipes($recipes) 
        {
            foreach ($recipes as $recipe) {
                $ingredientsJson = json_encode($recipe->recipe->ingredientLines);
                $dietLabelsJson = json_encode($recipe->recipe->dietLabels);
                $healthLabelsJson = json_encode($recipe->recipe->healthLabels);

                Recipe::create([
                    'label' => $recipe->recipe->label,
                    'image' => $recipe->recipe->image,
                    'url' => $recipe->recipe->url,
                    'yield' => $recipe->recipe->yield,
                    'ingredientLines' => $ingredientsJson,
                    'dietLabels' => $dietLabelsJson,
                    'healthLabels' => $healthLabelsJson
                ]);
            }
        }

        seedRecipes($recipesPasta);
        seedRecipes($recipesPizza);
        seedRecipes($recipesPotato);

    }
}
