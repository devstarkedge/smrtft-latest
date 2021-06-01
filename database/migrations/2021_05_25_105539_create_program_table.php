<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_id');
            $table->string('program_name')->nullable();
            $table->string('program_title')->nullable();
            $table->string('program_desc')->nullable();
            $table->string('program_image')->nullable();
            $table->string('number_of_weeks')->nullable();
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
        Schema::dropIfExists('program');
    }
}
