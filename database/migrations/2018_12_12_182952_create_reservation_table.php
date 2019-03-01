<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('reservationID');
            $table->unsignedInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            $table->unsignedInteger('restaurantID');
            $table->foreign('restaurantID')->references('restaurantID')->on('restaurants');
            $table->string('reservationMessage');
            $table->string('reservationSeats');
            $table->string('reservationTable')->nullable();
            $table->string('reservationDate');
            $table->string('reservationTime');
            $table->string('reservationStatus');
            $table->string('feedbackStatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
