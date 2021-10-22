<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRecordsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_records_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('program_id')->nullable();
            $table->string('workout_id')->nullable();
            $table->string('customer_id')->nullable();
             $table->string('week')->nullable();
            $table->boolean('is_seen')->default(1);
            $table->boolean('is_complete')->default(0);
            $table->date('seen_date')->default(date("Y-m-d H:i:s"));
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
        Schema::dropIfExists('user_records_history');
    }
}
