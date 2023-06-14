<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {


            $table->bigIncrements('id')->index();

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                ->references('id')->on('companies');

            $table->string('name');
            $table->string('rc')->nullable();
            $table->string('idfiscale')->nullable();
            $table->string('ice')->nullable();
            $table->string('patent')->nullable();
            $table->string('payment_mode')->nullable();
            $table->text('address')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('manager_phone')->nullable();
            $table->string('manager')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('centers');
    }
}
