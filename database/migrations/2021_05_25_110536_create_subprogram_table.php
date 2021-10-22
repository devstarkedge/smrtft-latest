<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubprogramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subprogram', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('program_id');
            $table->string('subprogram_name')->nullable();
            $table->text('subprogram_desc')->nullable();
            $table->string('subprogram_workouts')->nullable();
            $table->string('week')->nullable();
            $table->string('subprogram_image')->nullable();
            $table->string('nutrition_image')->nullable();
            $table->text('nutrition_desc')->nullable();
            $table->string('program_time')->nullable();
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
        Schema::dropIfExists('subprogram');
    }
}
