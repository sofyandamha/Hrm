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
            $table->integer('id_work_time')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_supervisor')->nullable();
            $table->string('month')->nullable();
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
        Schema::dropIfExists('log_em_stats');
    }
}
