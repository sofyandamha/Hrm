<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogEmStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_em_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_employee')->nullable();
            $table->integer('id_department')->nullable();
            $table->integer('id_status')->nullable();
            $table->timestamp('in_work')->nullable();
            $table->integer('id_work_time')->nullable();
            $table->timestamp('end_work')->nullable();
            $table->integer('is_active')->nullable();
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
        Schema::dropIfExists('log_em_stats');
    }
}
