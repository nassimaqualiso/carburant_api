<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->nullable();
            $table->string('capital', 200)->nullable();
            $table->date('date')->nullable();
            $table->string('idfiscale', 50)->nullable();
            $table->string('cnss', 255)->nullable();
            $table->string('trade_registry', 255)->nullable();
            $table->string('patent', 255)->nullable();
            $table->string('ice', 255)->nullable();
            $table->string('dg', 255)->nullable();
            $table->string('assistance_contact', 255)->nullable();
            $table->string('service_contact', 255)->nullable();
            $table->string('nature', 255)->nullable();
            $table->boolean('is_franchise')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
