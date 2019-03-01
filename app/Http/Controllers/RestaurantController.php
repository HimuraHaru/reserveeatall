<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Food;
use App\Http\Helpers;
use App\Reservation;
use App\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')) {
            $restaurants = Restaurant::where('restaurantName', 'LIKE', '%' . $request['search'] . '%')->get();
            if($restaurants->count() != 0) {
                return redirect('/#search')->with('getData', $restaurants);
            }
            else {
                return redirect('/#search')->with('getData', $restaurants);
            }
        }
        else {
            $restaurants = Restaurant::all();
            return view('welcome', compact('restaurants'));
        }

    }

    public function viewRestaurant(Request $request, $restaurantID)
    {
        $restaurant = Restaurant::findOrFail($restaurantID);
        $user = Auth::user();
        $time = Helpers::availableReservationTime($restaurant->openingTime, $restaurant->closingTime);

        if($request->has('search')) {
            $foods = Food::where('restaurantID', $restaurant->restaurantID)->where('foodName', 'LIKE', '%' . $request['search'] . '%')->get();
        }

        else {
            $foods = Food::where('restaurantID', $restaurant->restaurantID)->get();
        }

        if($request->has('filter') && $request->input('filter') == "latestDate") {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID','feedbacks.rating')
                ->orderBy('feedbacks.created_at', 'desc')
                ->paginate(3);
        }

        elseif($request->has('filter') && $request->input('filter') == "mostLikes") {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID', 'feedbacks.likeCount','feedbacks.rating')
                ->orderBy('feedbacks.likeCount', 'desc')
                ->paginate(3);
        }

        elseif($request->has('filter') && $request->input('filter') == "mostDislikes") {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID', 'feedbacks.dislikeCount','feedbacks.rating')
                ->orderBy('feedbacks.dislikeCount', 'desc')
                ->paginate(3);
        }

        else {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID', 'feedbacks.rating')
                ->orderBy('feedbacks.likeCount', 'desc')
                ->paginate(3);
        }


        return view('restaurant', compact('restaurant', 'foods', 'user', 'time', 'feedbacks'));
    }
}
