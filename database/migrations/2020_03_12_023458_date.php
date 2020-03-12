<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Date extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('full_date');
            $table->timestamp('day_ofWeek')->nullable();
            $table->integer('day_numberinWeek')->nullable();
            $table->integer('is_holiday')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('date');
    }
}
