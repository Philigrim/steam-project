<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD:database/migrations/2020_03_10_212826_create_event_table.php
class CreateEventTable extends Migration
=======
class CreateLecturersTable extends Migration
>>>>>>> f0fb2d9b7a155fd161b5256d8a6f2f427236bd35:database/migrations/2020_03_06_210616_create_lecturers_table.php
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD:database/migrations/2020_03_10_212826_create_event_table.php
        Schema::create('event', function (Blueprint $table) {
            $table->bigIncrements('id');
=======
        Schema::create('lecturers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
>>>>>>> f0fb2d9b7a155fd161b5256d8a6f2f427236bd35:database/migrations/2020_03_06_210616_create_lecturers_table.php
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
<<<<<<< HEAD:database/migrations/2020_03_10_212826_create_event_table.php
        Schema::dropIfExists('event');
=======
        Schema::dropIfExists('lecturers');
>>>>>>> f0fb2d9b7a155fd161b5256d8a6f2f427236bd35:database/migrations/2020_03_06_210616_create_lecturers_table.php
    }
}
