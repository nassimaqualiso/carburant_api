<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();

            $table->unsignedBigInteger('company_id')->index()->nullable();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->enum('type', ['company', 'particular'])->default('particular');
            $table->string('corporate_name')->nullable();
            $table->string('idfiscale', 50)->nullable();
            $table->string('trade_registry', 255)->nullable();
            $table->string('patent', 255)->nullable();
            $table->string('ICE', 255)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('CIN')->nullable();
            $table->enum('sex', ['M', 'F'])->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('manager_phone')->nullable();
            $table->string('manager_email')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->nullable();

            $table->timestamps();
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
        Schema::dropIfExists('customers');
    }
}
