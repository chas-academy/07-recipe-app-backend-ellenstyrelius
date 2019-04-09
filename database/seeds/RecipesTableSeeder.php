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

        foreach ($recipesPasta as $recipe) {
            $ingredients = $recipe->recipe->ingredientLines;
            $ingredientsJson = json_encode($ingredients);
            $dietLabels = $recipe->recipe->dietLabels;
            $dietLabelsJson = json_encode($dietLabels);
            $healthLabels = $recipe->recipe->healthLabels;
            $healthLabelsJson = json_encode($healthLabels);

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

        // for ($i = 0; $i < 100; $i++) {
        //     Recipe::create([
        //         'label' => $recipesPasta->recipe->label,
        //         'image' => $recipesPasta->recipe->image,
        //         'url' => $recipesPasta->recipe->url,
        //         'yield' => $recipesPasta->recipe->yield,
        //         'ingredientLines' => $recipesPasta->recipe->ingredientLines,
        //         'dietLabels' => $recipesPasta->recipe->dietLabels,
        //         'healthLabels' => $recipesPasta->recipe->healthLabels,
        //     ]);
        // }
    }
}
