<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRocordsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rocords_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subprogram_id')->nullable();
            $table->string('subprogram_details_id')->nullable();
            $table->string('customer_id')->nullable();
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
        Schema::dropIfExists('user_rocords_history');
    }
}
