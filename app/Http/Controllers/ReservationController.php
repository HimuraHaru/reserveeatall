<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use App\Reservation;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reserve(Request $request, $restaurantID)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^(09|639)\d{9}$/', 'numeric', 'digits:12'],
        ]);

        if ($validator->fails()) {
            return redirect('/restaurant/' . $restaurantID . '#referenceUrl=reserve')
                ->withErrors($validator)
                ->withInput();
        }

        else {
            $restaurant = Restaurant::findOrFail($restaurantID);
            $user = auth()->id();

            $reservation = Reservation::where('userID', $user)
                ->where('reservationTime', $request['time'])
                ->where('reservationStatus', 'approved')
                ->where('reservationDate', $request['datepicker'])
                ->first();

            if($reservation == NULL) {
                $reserve = new Reservation();
                $reserve->userID = $user;
                $reserve->restaurantID = $restaurant->restaurantID;
                $reserve->reservationMessage = $request['message'];
                $reserve->reservationSeats = $request['seats'];
                $reserve->reservationDate = $request['datepicker'];
                $reserve->reservationTime = $request['time'];
                $reserve->reservationStatus = Helpers::pending();
                $reserve->feedbackStatus = Helpers::pending();
                $reserve->save();

                swal()->success('Thank you! An sms message will be send if your reservation is approved.');
                return redirect('/restaurant/' . $restaurantID . '#referenceUrl=reserve');
            }

            else {
                swal()->error('Sorry. You already have an approved schedule within this schedule.');
                return redirect('/restaurant/' . $restaurantID . '#referenceUrl=reserve');
            }

        }

    }

    public function reservationList($category)
    {
        if(Helpers::checkIfUser()) {

            if($category == Helpers::pending()) {

                $reservations = Reservation::where('userID', Helpers::userID())
                    ->join('restaurants', 'reservations.restaurantID', '=', 'restaurants.restaurantID')
                    ->select('reservations.*', 'restaurants.restaurantName')
                    ->where('reservationStatus', Helpers::pending())
                    ->orderBy('reservationDate', 'desc')
                    ->paginate(10);

                return view('dashboard/reservation/list', compact('reservations', 'category'));

            }

            elseif($category == Helpers::approved()) {

                $reservations = Reservation::where('userID', Helpers::userID())
                    ->join('restaurants', 'reservations.restaurantID', '=', 'restaurants.restaurantID')
                    ->select('reservations.*', 'restaurants.restaurantName')
                    ->where('reservationStatus', Helpers::approved())
                    ->orWhere('reservationStatus', Helpers::reminded())
                    ->orderBy('reservationDate', 'desc')
                    ->paginate(10);

                return view('dashboard/reservation/list', compact('reservations', 'category'));

            }

            elseif($category == Helpers::completed()) {
                $reservations = Reservation::where('userID', Helpers::userID())
                    ->join('restaurants', 'reservations.restaurantID', '=', 'restaurants.restaurantID')
                    ->select('reservations.*', 'restaurants.restaurantName')
                    ->where('reservationStatus', Helpers::completed())
                    ->orderBy('reservationDate', 'desc')
                    ->paginate(10);



                return view('dashboard/reservation/list', compact('reservations', 'category'));
            }

            else {
                return back();
            }

        }

        elseif(Helpers::checkIfManager()) {

            if($category == Helpers::pending()) {
                $reservations = Reservation::join('users', function ($join) {

                    $join->on('reservations.userID', '=','users.id')
                        ->where('reservations.restaurantID', '=', Helpers::managerRestaurantID());
                })
                    ->where('reservationStatus', Helpers::pending())
                    ->orderBy('reservationDate', 'desc')
                    ->paginate(10);
            }

            elseif($category == Helpers::approved()) {
                $reservations = Reservation::join('users', function ($join) {

                    $join->on('reservations.userID', '=','users.id')
                        ->where('reservations.restaurantID', '=', Helpers::managerRestaurantID());
                })
                    ->where('reservationStatus', Helpers::approved())
                    ->orWhere('reservationStatus', Helpers::reminded())
                    ->orderBy('reservationDate', 'desc')
                    ->paginate(10);
            }

            elseif($category == Helpers::completed()) {
                $reservations = Reservation::join('users', function ($join) {

                    $join->on('reservations.userID', '=','users.id')
                        ->where('reservations.restaurantID', '=', Helpers::managerRestaurantID());
                })
                    ->where('reservationStatus', Helpers::completed())
                    ->orderBy('reservationDate', 'desc')
                    ->paginate(10);
            }

            return view('dashboard/reservation/list', compact('reservations', 'category'));
        }
    }

    public function reservationListPost($category, $action, $reservationID) {

        $reservation = Reservation::findOrFail($reservationID);
        $user = User::findOrFail($reservation->userID);
        $restaurant = Restaurant::findOrFail($reservation->restaurantID);
        $nexmo = app('Nexmo\Client');

        if($category == Helpers::pending() && $action == Helpers::approved() && Helpers::checkIfManager()) {
            $reservation->reservationStatus = Helpers::approved();
            $reservation->save();
            swal()->success('Successfully approved!');

            $nexmo->message()->send([
                'to'   => $user->contact,
                'from' => 'Reserve Eat All',
                'text' => 'Hello ' . ucwords($user->name) . ' Your reservation has been approved. See you on ' . $reservation->reservationDate . ', ' . Helpers::convertTime($reservation->reservationTime)
            ]);
        }

        elseif($category == Helpers::pending() && $action == Helpers::canceled()) {
            $reservation->reservationStatus = Helpers::canceled();
            $reservation->save();
            swal()->success('Successfully canceled!');

            $nexmo->message()->send([
                'to'   => $user->contact,
                'from' => 'Reserve Eat All',
                'text' => 'Hello ' . ucwords($user->name) . ' Sorry your reservation has been canceled.'
            ]);
        }

        elseif($category == Helpers::approved() && $action == Helpers::completed() && Helpers::checkIfManager()) {
            $reservation->reservationStatus = Helpers::completed();
            $reservation->save();
            swal()->success('Successfully completed!');
        }

        return back();
    }
}
