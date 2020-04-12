<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerHasSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturer_has_subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lecturer_id');
            $table->foreign('lecturer_id')->references('id')->on('lecturers');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects');
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
        Schema::dropIfExists('lecturer_has_subject');
    }
}
