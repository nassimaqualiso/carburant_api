<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_brand_id');
            $table->unsignedBigInteger('vehicle_model_id');
            $table->unsignedBigInteger('vehicle_energy_id');
            $table->unsignedBigInteger('vehicle_period_id');
            $table->unsignedBigInteger('vehicle_length_id');
            $table->userActions();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_brand_id')->references('id')->on('vehicle_brands')->onDelete('cascade');
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models')->onDelete('cascade');
            $table->foreign('vehicle_energy_id')->references('id')->on('vehicle_energies')->onDelete('cascade');
            $table->foreign('vehicle_period_id')->references('id')->on('vehicle_periods')->onDelete('cascade');
            $table->foreign('vehicle_length_id')->references('id')->on('vehicle_lengths')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_cars');
    }
}