<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Attendfinger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendfinger', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_employee')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('in_time')->nullable();
            $table->string('out_time')->nullable();
            $table->integer('create_by')->nullable();
            $table->integer('update_by')->nullable();
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
        //
    }
}
