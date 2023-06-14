<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id');
            $table->string('registration_car');
            $table->string('chassis_no');
            $table->date('date_mce');
            $table->bigInteger('vehicle_brand_id');
            $table->bigInteger('vehicle_model_id');
            $table->bigInteger('vehicle_energy_id');
            $table->bigInteger('vehicle_period_id');
            $table->bigInteger('vehicle_length_id');
            $table->timestamps();
            $table->userActions();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
