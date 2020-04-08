<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('room_number');
            $table->integer('capacity');
<<<<<<< HEAD
            $table->integer('steam_id');
            $table->foreign('steam_id')->references('id')->on('steam_centers');
=======
            $table->integer('steam_center_id');
            $table->foreign('steam_center_id')->references('id')->on('steam_centers');
>>>>>>> 92f36c02cdce64fa1030a72ec3159dc4e83a98b8
            $table->string('course_category');
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
        Schema::dropIfExists('rooms');
    }
}
