<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForfaitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forfaits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->unsignedBigInteger('data_car_id');
            $table->unsignedBigInteger('nature_id');
            $table->unsignedBigInteger('sub_nature_id')->nullable();
            $table->timestamps();
            $table->userActions();
            $table->softDeletes();

            $table->foreign('data_car_id')->references('id')->on('data_cars')->onDelete('cascade');
            $table->foreign('nature_id')->references('id')->on('natures')->onDelete('cascade');
            $table->foreign('sub_nature_id')->references('id')->on('sub_natures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forfaits');
    }
}
