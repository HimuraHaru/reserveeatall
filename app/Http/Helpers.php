<?php

namespace App\Http;
use App\Feedback;
use App\Reservation;
use App\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class Helpers
{

    public static function generateEmail($name)
    {
        $removeSpecialChar = preg_replace('/[^A-Za-z0-9\-]/', '', $name);

        return strtolower($removeSpecialChar) . '@yahoo.com';
    }

    public static function role() {
        return auth()->user()->role;
    }

    public static function admin() {
        return Config::get('constants.role.admin');
    }

    public static function manager() {
        return Config::get('constants.role.manager');
    }

    public static function user() {
        return Config::get('constants.role.user');
    }

    public static function checkIfAdmin() {
        $getRole = Helpers::role();
        $admin = Helpers::admin();

        if($getRole == $admin) {
            return $admin;
        }
    }

    public static function checkIfManager() {
        $getRole = Helpers::role();
        $manager = Helpers::manager();

        if($getRole == $manager) {
            return $manager;
        }
    }

    public static function checkIfUser() {
        $getRole = Helpers::role();
        $user = Helpers::user();

        if($getRole == $user) {
            return $user;
        }
    }

    public static function userID() {
        return auth()->user()->id;
    }

    public static function managerRestaurantID() {
        return auth()->user()->restaurantID;
    }

    public static function operatingHours($openingTime, $closingTime) {
        $o = Carbon::create(0000, 00, 00, $openingTime, 00, 00);
        $c = Carbon::create(0000, 00, 00, $closingTime, 00, 00);

        return $o->format('h:i A') . ' - ' . $c->format('h:i A');
    }

    public static function convertTime($time) {
        $t = Carbon::create(0000, 00, 00, $time, 00, 00);
        return $t->format('h:i A');
    }

    public static function reservationReminder($time) {
        $t = Carbon::create(0000, 00, 00, $time, 00, 00);
        return $t->subMinutes(30)->format('h:i A');
    }

    public static function reservationLate($time) {
        $t = Carbon::create(0000, 00, 00, $time, 00, 00);
        return $t->addMinutes(15)->format('h:i A');
    }

    public static function availableReservationTime($openingTime, $closingTIme) {
        return $closingTIme - $openingTime;
    }

    public static function pending() {
        return "pending";
    }

    public static function approved() {
        return "approved";
    }

    public static function checkIn() {
        return "checkedIn";
    }

    public static function checkOut() {
        return "checkedOut";
    }

    public static function completed() {
        return "completed";
    }

    public static function canceled() {
        return "canceled";
    }

    public static function reminded() {
        return "reminded";
    }

    public static function restaurants() {
        return Restaurant::all();
    }

    public static function ratings($restaurantID) {
        $restaurant = Restaurant::findOrFail($restaurantID);
        $ratings = [];

        for($i = 1; $i <= 5; $i++) {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->where('rating', $i)
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('feedbacks.rating')
                ->orderBy('feedbacks.created_at', 'desc')
                ->get();

            array_push($ratings, $feedbacks);
        }

        $five = [];
        $four = [];
        $three = [];
        $two = [];
        $one = [];

        foreach($ratings as $rating) {
            foreach($rating as $data) {
                if($data->rating == 5) {
                    array_push($five, $data->rating);
                }
                elseif($data->rating == 4) {
                    array_push($four, $data->rating);
                }
                elseif($data->rating == 3) {
                    array_push($three, $data->rating);
                }
                elseif($data->rating == 2) {
                    array_push($two, $data->rating);
                }
                elseif($data->rating == 1) {
                    array_push($one, $data->rating);
                }
            }
        }

        /*
         * Formula used weighted average
         * Algorithm used:
         * https://stackoverflow.com/questions/10196579/algorithm-used-to-calculate-5-star-ratings/10196621
         */
        $weight = 5*collect($five)->count() + 4*collect($four)->count() + 3*collect($three)->count() + 2*collect($two)->count() + 1*collect($one)->count();
        $numOfVotes = collect($five)->count() + collect($four)->count() + collect($three)->count() + collect($two)->count() + collect($one)->count();
        if($weight == 0 && $numOfVotes == 00) {
            return "No ratings";
        }
        else {
            $total = number_format($weight / $numOfVotes, 1);
            return $total*20;
        }

    }

}