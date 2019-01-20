<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Reservation;
use App\Restaurant;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkIfAdminOrManager:role');
    }

    public function index() {
        if (Helpers::checkIfAdmin()) {
            $restaurants = Restaurant::orderBy('restaurantName', 'asc')->get();

            return view('dashboard.statistic.generate', compact('restaurants'));
        }

        else {
            return back();
        }
    }

    public function generate(Request $request) {
        if (Helpers::checkIfAdmin()) {

            $reservations = Reservation::where('reservationDate', 'LIKE', '%' . $request['year'] . '-' . $request['month'] . '%')->get();
            $restaurantID = Restaurant::findOrFail($request['restaurantID']);
            Carbon::createFromTime(12, 0, 0, 'Europe/London');

            $date = Carbon::createFromDate($request['year'], $request['month'])->format('M. Y');

            $male = 0;

            foreach($reservations as $reservation) {
                $user = User::where('id', $reservation->userID)->where('gender', 'Male')->count();

                if($user != null) {
                    $male += 1;
                }
            }

            $female = 0;

            foreach($reservations as $reservation) {
                $user = User::where('id', $reservation->userID)->where('gender', 'Female')->count();

                if($user != null) {
                    $female += 1;
                }
            }

            return view('dashboard.statistic.statistics', compact('reservations', 'male', 'restaurantID', 'female', 'date'));
        }

        else {
            return back();
        }
    }
}