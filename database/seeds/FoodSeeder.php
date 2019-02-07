<?php

use Illuminate\Database\Seeder;
use App\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * List of restaurants
         * Please do update this to have your own reference.
         * Gustav - restaurantID = 1
         * Restaurant2 - restaurantID = 2 and so on..
         */

        /*
         * List of foodCategory
         * breakfast
         * special
         * desert
         * dinner
         */
        $food1 = Food::create([
            'foodName' => 'Sisig',
            'foodPrice' => '100',
            'foodIngredient' => 'Pork, Egg, etc.',
            'foodImage' => 'sisig.jpg',
            'foodCategory' => 'dinner',
            'restaurantID' => 1
        ]);
    }
}
