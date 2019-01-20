<?php

namespace App\Console\Commands;

use App\Http\Helpers;
use App\Reservation;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkReservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $nexmo = app('Nexmo\Client');
        $currentDate = Carbon::now('Asia/Manila')->format('Y-m-d');
        $currentTime = Carbon::now('Asia/Manila')->format('h:i A');
        $reservationReminder = Reservation::where('reservationDate', $currentDate)->where('reservationStatus', Helpers::approved())->get();
        $reservationLate = Reservation::where('reservationDate', $currentDate)->where('reservationStatus', Helpers::reminded())->get();

        foreach($reservationReminder as $reservationR) {
            $reservationTime = Helpers::reservationReminder($reservationR->reservationTime);

            if($reservationTime == $currentTime) {
                $reservation = Reservation::findOrFail($reservationR->reservationID);

                $user = User::findOrFail($reservation->userID);

                $nexmo->message()->send([
                    'to'   => $user->contact,
                    'from' => 'Reserve Eat All',
                    'text' => 'Hello ' . ucwords($user->name) . '. Your reservation in ' . $reservation->reservationDate . ', will be in 15 minutes.'
                ]);

                $reservation->reservationStatus = Helpers::reminded();
                $reservation->save();
            }

        }

        foreach($reservationLate as $reservationL) {
            $reservationTime = Helpers::reservationLate($reservationL->reservationTime);

            if($reservationTime == $currentTime) {
                $reservation = Reservation::findOrFail($reservationL->reservationID);

                $user = User::findOrFail($reservation->userID);

                $nexmo->message()->send([
                    'to'   => $user->contact,
                    'from' => 'Reserve Eat All',
                    'text' => 'Hello ' . ucwords($user->name) . '. Your reservation in ' . $reservation->reservationDate . ', has been canceled.'
                ]);

                $reservation->reservationStatus = Helpers::canceled();
                $reservation->save();
            }

        }



    }
}
