<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeeCenter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_center', function (Blueprint $table) {

            $table->unsignedBigInteger('employee_id');

            $table->unsignedBigInteger('center_id');

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade');

            $table->foreign('center_id')->references('id')->on('centers')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_center');
    }
}
