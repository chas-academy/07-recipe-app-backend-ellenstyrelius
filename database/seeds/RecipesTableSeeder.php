<?php

use Illuminate\Database\Seeder;

use App\Recipe;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recipe::truncate(); //för att vara säker på att få helt ny fejkdata varje gång seedern körs

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Recipe::create([
                'label' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'image' => $faker->url,
                'url' => $faker->url,
                'yield' => $faker->randomDigit,
                'healthLabels' => $faker->words($nb = 4, $asText = true),
                'ingredientLines' => $faker->words($nb = 5, $asText = true),
                'dietLabels' => $faker->words($nb = 4, $asText = true)
            ]);
        }
    }
}
