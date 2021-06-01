<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subcategory_id');
            $table->string('workout_type_name');
            $table->string('workout_type_desc')->nullable();
            $table->string('workout_type_image')->nullable();
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
        Schema::dropIfExists('workout_type');
    }
}
