<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->boolean('all_customer')->default(false);
            $table->boolean('all_center')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('type', ['percentage', 'flat']);
            $table->double('value')->nullable();
            $table->double('minimum_qty')->nullable();
            $table->double('maximum_qty')->nullable();
            $table->string('days')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('discounts');
    }
}
