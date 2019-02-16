<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

Route::get('/', 'RestaurantController@index')->name('restaurant');
Route::get('/restaurant/{restaurantID}', 'RestaurantController@viewRestaurant')->name('view-restaurant');
Route::post('/reserve/{restaurantID}', 'ReservationController@reserve')->name('reserve');

Route::get('restaurant/view/feedback/{restaurantID}', 'FeedbackController@viewFeedback')->name('view-feedback');

//Like
Route::get('/like/{feedbackID}/restaurant/{restaurantID}/{category}', 'LikeController@likeFeedback')->name('like-feedback');

//Dislike
//Route::get('/dislike/{feedbackID}/restaurant/{restaurantID}/{category}', 'DislikeController@dislikeFeedback')->name('dislike-feedback');


Route::prefix('dashboard')->middleware('verified')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::prefix('account')->group(function () {
        Route::get('/', 'AccountController@index')->name('account');
        Route::get('/list', 'Admin\AccountController@accountList')->name('account-list');

        Route::get('/edit-account/{category}', 'AccountController@editAccount')->name('edit-account');
        Route::post('/edit-account-post/{category}/{accountID}', 'AccountController@editAccountPost')->name('edit-account-post');
    });

    //Restaurant
    Route::prefix('restaurants')->group(function () {
        //Admin
        Route::get('/', 'Admin\RestaurantController@index')->name('list-restaurant');
        Route::get('/view-menu/{id}', 'Admin\RestaurantController@viewMenu')->name('view-menu');
        Route::get('/delete-restaurant/{id}', 'Admin\RestaurantController@deleteRestaurant')->name('delete-restaurant');

        Route::get('/add-restaurant', 'Admin\RestaurantController@addRestaurant')->name('add-restaurant');
        Route::post('/add-restaurant-post', 'Admin\RestaurantController@addRestaurantPost')->name('add-restaurant-post');

        Route::get('/edit-restaurant/{id}', 'Admin\RestaurantController@editRestaurant')->name('edit-restaurant');
        Route::post('/edit-restaurant-post/{id}', 'Admin\RestaurantController@editRestaurantPost')->name('edit-restaurant-post');

        //Foods
        Route::prefix('food')->group(function () {
            Route::get('/', 'Admin\FoodController@index')->name('list-food');
            Route::get('/view-food/{foodID}', 'Admin\FoodController@viewFood')->name('view-food');
            Route::get('/delete-food/{foodID}', 'Admin\FoodController@deleteFood')->name('delete-food');

            Route::get('/add-food/{restaurantID}', 'Admin\FoodController@addFood')->name('add-food');
            Route::post('/add-food-post/{restaurantID}', 'Admin\FoodController@addFoodPost')->name('add-food-post');

            Route::get('/edit-food/{foodID}', 'Admin\FoodController@editFood')->name('edit-food');
            Route::post('/edit-food-post/{foodID}', 'Admin\FoodController@editFoodPost')->name('edit-food-post');
        });
    });

    //Reservation
    Route::prefix('reservation')->group(function () {

        Route::get('/list/{category}', 'ReservationController@reservationList')->name('list-reservation');
        Route::get('/list/{category}/{action}/{reservationID}', 'ReservationController@reservationListPost')->name('list-reservation-post');
    });

    //Feedback
    Route::prefix('feedback')->group(function () {

        Route::get('/add/{restaurantID}', 'FeedbackController@addFeedback')->name('add-feedback');
        Route::post('/add-post/{reservationID}', 'FeedbackController@addFeedbackPost')->name('add-feedback-post');

        Route::get('/list-feedback', 'FeedbackController@listFeedback')->name('list-feedback');
    });

    //Statistics
    Route::prefix('statistics')->group(function () {

        Route::get('/', 'Admin\StatisticsController@index')->name('statistics');
        Route::get('/generate', 'Admin\StatisticsController@generate')->name('generate');
    });

    //Logs
    Route::prefix('logs')->group(function () {

        Route::get('/', 'Admin\LogController@index')->name('logs');
    });

});

