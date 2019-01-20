<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('feedbackID');
            $table->unsignedInteger('reservationID');
            $table->foreign('reservationID')->references('reservationID')->on('reservations');
            $table->unsignedInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            $table->text('feedbackMessage');
            $table->integer('likeCount');
            $table->integer('dislikeCount');
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
        Schema::dropIfExists('feedbacks');
    }
}
