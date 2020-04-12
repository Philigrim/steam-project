<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityHasSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_has_school', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('school');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_has_school');
    }
}
