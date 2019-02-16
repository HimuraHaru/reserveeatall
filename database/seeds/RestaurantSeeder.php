<?php

use Illuminate\Database\Seeder;
use App\Restaurant;
use App\User;
use Carbon\Carbon;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Restaurant
		 * restaurantID = 1
		 * restaurantID will be used on the FoodSeeder to know where would be the food would be added.
         * restaurantID will be used on creating a User to know what would be that user will be managing.
         * openingTime and closingTime is following the military time
         * e.g  7 = 7:00AM
         * e.g 13 = 1:00PM
         */
        $restaurant1 = Restaurant::create([
            'restaurantName' => 'Gustav',
            'restaurantAddress' => 'Angeles City',
            'restaurantLogo' => 'no_image.jpg',
            'openingTime' => 8,
            'closingTime' => 20,
            'restaurantSeatsAvail' => '20',
            'created_at' => new Carbon()
        ]);

        /*
         * When creating a restaurant we're automatically creating a user who will manage it.
         */
        $user1 = User::create([
            'name' => 'Gustav',
            'email' => 'gustav@yahoo.com',
            'password' => bcrypt('1234'),
            'created_at' => new Carbon(),
            'email_verified_at' => new Carbon(),
            'role' => 'MANAGER',
            'contact' => '639774414592',
            'restaurantID' => 1 //the restaurantID is being generated through auto incrementing. So the ID of the next restaurant would be 2.
        ]);

    }
}
