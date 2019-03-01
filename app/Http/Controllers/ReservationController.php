<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use App\Reservation;
use App\Restaurant;
use App\User;
use Illuminate\Http\Request;
use App\Log;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reserve(Request $request, $restaurantID)
    {

        $restaurant = Restaurant::findOrFail($restaurantID);
        $manager = User::where('restaurantID', $restaurant->restaurantID)->first();

        if($manager->contact != null) {
            $user = auth()->id();
            $getUser = User::findOrFail($user);

            $reservation = Reservation::where('userID', $user)
                ->where('reservationTime', $request['time'])
                ->where('reservationStatus', 'approved')
                ->where('reservationDate', $request['datepicker'])
                ->first();

            if($request['seats'] < $restaurant->restaurantSeatsAvail) {
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


                    $getReservationId = Reservation::where('userID', $user)
                        ->where('restaurantID', $restaurant->restaurantID)
                        ->where('reservationMessage', $request['message'])
                        ->where('reservationSeats', $request['seats'])
                        ->where('reservationDate', $request['datepicker'])
                        ->where('reservationTime', $request['time'])
                        ->first();

                    $log = new Log();
                    $log->reservationID = $getReservationId->reservationID;
                    $log->restaurantID = $getReservationId->restaurantID;
                    $log->save();

                   $nexmo = app('Nexmo\Client');
                   $nexmo->message()->send([
                       'to'   => $manager->contact,
                       'from' => 'Reserve Eat All',
                       'text' => 'Hello ' . ucwords($manager->name) . '. There\'s a new reservation with the following details.' .
                           ' Name: ' .ucwords($getUser->name). ',' .
                           ' Seats: ' .$request['seats']. ',' .
                           ' Date: ' .$request['datepicker']. ',' .
                           ' Time: ' .Helpers::convertTime($request['time']). ',' .
                           ' Message: ' .ucfirst($request['message']) . ' Please review this on the reservation section -> pending.'
                   ]);  

                    swal()->success('Thank you! An sms message will be send if your reservation is approved.');
                    return redirect('/restaurant/' . $restaurantID . '#referenceUrl=reserve');
                }

                else {
                    swal()->error('Sorry. You already have an approved schedule within this schedule.');
                    return redirect('/restaurant/' . $restaurantID . '#referenceUrl=reserve');
                }
            }

            else {
                swal()->error('Sorry. The seats that you are requesting is too much. The available seats is only ' . $restaurant->restaurantSeatsAvail);
                return redirect('/restaurant/' . $restaurantID . '#referenceUrl=reserve');
            }

        }

        else {
            swal()->error('Sorry. The restaurant is not available for reservation.');
            return redirect('/restaurant/' . $restaurantID . '#referenceUrl=reserve');
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

            elseif($category == Helpers::checkIn()) {

                $reservations = Reservation::where('userID', Helpers::userID())
                    ->join('restaurants', 'reservations.restaurantID', '=', 'restaurants.restaurantID')
                    ->select('reservations.*', 'restaurants.restaurantName')
                    ->where('reservationStatus', Helpers::checkIn())
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

            elseif($category == Helpers::checkIn()) {
                $reservations = Reservation::join('users', function ($join) {

                    $join->on('reservations.userID', '=','users.id')
                        ->where('reservations.restaurantID', '=', Helpers::managerRestaurantID());
                })
                    ->where('reservationStatus', Helpers::checkIn())
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

    public function reservationListPost(Request $request, $category, $action, $reservationID) {

        $request->validate([
            'reservationTable' => 'int',
        ]);
        
        $reservation = Reservation::findOrFail($reservationID);
        $user = User::findOrFail($reservation->userID);
        $restaurant = Restaurant::findOrFail($reservation->restaurantID);

        $table = $request['reservationTable'];
      //  $nexmo = app('Nexmo\Client');

        if($category == Helpers::pending() && $action == Helpers::approved() && Helpers::checkIfManager()) {
            $reservation->reservationTable = $table;
            $reservation->reservationStatus = Helpers::approved();
            $reservation->save();

            $reservedSeats = $reservation->reservationSeats; //seats reserved
            $getAvailSeats = $restaurant->restaurantSeatsAvail; //available seats
            $updatedSeats = $getAvailSeats - $reservedSeats; // get new number of seats

            $restaurant->restaurantSeatsAvail = $updatedSeats;
            $restaurant->save();


            swal()->success('Successfully approved!');

           $nexmo->message()->send([
                'to'   => $user->contact,
                'from' => 'Reserve Eat All',
                'text' => 'Hello ' . ucwords($user->name) . '. Your reservation has been approved. See you on ' . $reservation->reservationDate . ', ' . Helpers::convertTime($reservation->reservationTime)
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

        elseif($category == Helpers::approved() && $action == Helpers::checkIn() && Helpers::checkIfManager()) {
            $reservation->reservationStatus = Helpers::checkIn();
            $reservation->save();
            swal()->success('Successfully completed!');

            $nexmo->message()->send([
                'to'   => $user->contact,
                'from' => 'Reserve Eat All',
                'text' => 'Hello ' . ucwords($user->name) . ' You have successfully checked in. Enjoy!'
            ]); 
            
        }

        elseif($category == Helpers::checkIn() && $action == Helpers::completed() && Helpers::checkIfManager()) {
            $reservedSeats = $reservation->reservationSeats;
            $restaurantSeats = $restaurant->restaurantSeatsAvail;
            $updatedSeats = $restaurantSeats + $reservedSeats;

            $reservation->reservationStatus = Helpers::completed();
            $reservation->save();

            $restaurant->restaurantSeatsAvail = $updatedSeats;
            $restaurant->save();

            swal()->success('Successfully completed!');
        }

        return back();
    }
}
