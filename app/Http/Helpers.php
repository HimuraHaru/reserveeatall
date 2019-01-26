<?php

namespace App\Http;
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
        return $t->subMinutes(15)->format('h:i A');
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

    public static function completed() {
        return "completed";
    }

    public static function canceled() {
        return "canceled";
    }

    public static function reminded() {
        return "reminded";
    }

}