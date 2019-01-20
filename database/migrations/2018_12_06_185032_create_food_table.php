<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->increments('foodID');
            $table->string('foodName');
            $table->string('foodPrice');
            $table->string('foodIngredient');
            $table->string('foodImage');
            $table->string('foodCategory');
            $table->unsignedInteger('restaurantID');
            $table->foreign('restaurantID')->references('restaurantID')->on('restaurants')->onDelete('cascade');
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
        Schema::dropIfExists('foods');
    }
}
