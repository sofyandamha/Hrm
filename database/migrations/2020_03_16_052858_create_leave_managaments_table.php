<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveManagamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_managaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_employee')->nullable();
            $table->integer('id_leave_type')->nullable();
            $table->string('start_leave')->nullable();
            $table->string('end_leave')->nullable();
            $table->string('remak')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('leave_managaments');
    }
}
