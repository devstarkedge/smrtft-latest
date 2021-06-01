<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubprogramDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subprogram_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subprogram_id');
            $table->string('user_id')->nullable();
            $table->string('subprogram_details_name')->nullable();
            $table->string('subprogram_details_desc')->nullable();
            $table->string('subprogram_details_url')->nullable();
            $table->string('subprogram_details_time')->nullable();
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
        Schema::dropIfExists('subprogram_details');
    }
}
