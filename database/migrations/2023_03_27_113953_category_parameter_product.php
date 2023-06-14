<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryParameterProduct extends Migration
{
    public function up()
    {
        Schema::create('category_parameter_product', function (Blueprint $table) {

            $table->unsignedBigInteger('category_parameter_id');

            $table->unsignedBigInteger('product_id');

            $table->string('value', 20)->nullable();

            $table->foreign('category_parameter_id')->references('id')->on('category_parameters')
                ->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')
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
        Schema::dropIfExists('category_parameter_product');
    }
}
