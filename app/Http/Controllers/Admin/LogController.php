<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers;
use App\Log;
use App\Reservation;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        if(Helpers::checkIfAdmin()) {
            if(request()->has('restaurantID') && request()->restaurantID != NULL) {
                $logs = Log::where('restaurantID', request()->restaurantID)->paginate(10);
                return view("dashboard.log.list", compact('logs'));
            }
            else {
                return back();
            }
        }

        elseif(Helpers::checkIfManager()) {
            $logs = Log::where('restaurantID', Helpers::managerRestaurantID())->paginate(10);
            return view("dashboard.log.list", compact('logs'));
        }

        else {
            return back();
        }
    }
}
