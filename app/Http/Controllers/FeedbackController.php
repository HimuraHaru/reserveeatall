<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Helpers;
use App\Reservation;
use App\Restaurant;
use App\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function construct()
    {
        $this->middleware('auth');
    }

    public function addFeedback($reservationID) {

        $reservation = Reservation::findOrFail($reservationID);

        if($reservation->feedbackStatus == Helpers::pending()) {
            $restaurant = Restaurant::findOrFail($reservation->restaurantID);

            return view('dashboard.feedback.add', compact('restaurant', 'reservation'));
        }

        else {
            return back();
        }
    }

    public function addFeedbackPost(Request $request, $reservationID) {

        $reservation = Reservation::findOrFail($reservationID);

        if($reservation->feedbackStatus == Helpers::pending()) {
            $feedback = new Feedback();
            $feedback->reservationID = $reservation->reservationID;
            $feedback->rating = $request['rating'];
            $feedback->feedbackMessage = $request['feedbackMessage'];
            $feedback->userID = Helpers::userID();
            $feedback->likeCount = 0;
            $feedback->dislikeCount = 0;
            $reservation->feedbackStatus = Helpers::completed();

            $feedback->save();
            $reservation->save();

            swal()->success('Thank you for your feedback!');
            return redirect()->route('list-reservation', Helpers::completed());
        }

        else {
            return back();
        }

    }

    public function listFeedback() {

        if(Helpers::checkIfAdmin()) {

            $feedbacks = Feedback::paginate(1);

            return view('dashboard.feedback.list', compact('feedbacks'));

        }

        elseif(Helpers::checkIfManager()) {

            $feedbacks = Reservation::where('restaurantID', Helpers::managerRestaurantID())
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.*')
                ->orderBy('feedbacks.created_at', 'asc')
                ->paginate(10);

            $restaurant = Restaurant::findOrFail(Helpers::managerRestaurantID());

            return view('dashboard.feedback.list', compact('feedbacks', 'restaurant'));

        }

        elseif(Helpers::checkIfUser()) {

            $feedbacks = Feedback::where('userID', Helpers::userID())
                ->orderBy('created_at', 'asc')
                ->paginate(10);

            return view('dashboard.feedback.list', compact('feedbacks'));

        }
    }

    public function viewFeedback(Request $request, $restaurantID)
    {
        $restaurant = Restaurant::findOrFail($restaurantID);
        $foods = Food::where('restaurantID', $restaurant->restaurantID)->get();
        $user = Auth::user();
        $time = Helpers::availableReservationTime($restaurant->openingTime, $restaurant->closingTime);

        if($request->has('filter') && $request->input('filter') == "latestDate") {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID')
                ->orderBy('feedbacks.created_at', 'desc')
                ->paginate(10);
        }

        elseif($request->has('filter') && $request->input('filter') == "mostLikes") {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID', 'feedbacks.likeCount')
                ->orderBy('feedbacks.likeCount', 'desc')
                ->paginate(10);
        }

//        elseif($request->has('filter') && $request->input('filter') == "mostDislikes") {
//            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
//                ->where('feedbackStatus', Helpers::completed())
//                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
//                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID', 'feedbacks.dislikeCount')
//                ->orderBy('feedbacks.dislikeCount', 'desc')
//                ->paginate(10);
//        }

        else {
            $feedbacks = Reservation::where('restaurantID', $restaurant->restaurantID)
                ->where('feedbackStatus', Helpers::completed())
                ->join('feedbacks', 'reservations.reservationID', '=', 'feedbacks.reservationID')
                ->select('reservations.*', 'feedbacks.feedbackMessage', 'feedbacks.created_at', 'feedbacks.feedbackID', 'feedbacks.rating')
                ->orderBy('feedbacks.created_at', 'desc')
                ->paginate(10);
        }

        return view('feedback', compact('restaurant', 'foods', 'user', 'time', 'feedbacks'));
    }
}
