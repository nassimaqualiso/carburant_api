<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NatureCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nature_category', function (Blueprint $table) {

            $table->unsignedBigInteger('nature_id');

            $table->unsignedBigInteger('product_category_id');

            $table->foreign('product_category_id')->references('id')->on('product_categories')
                ->onDelete('cascade');

            $table->foreign('nature_id')->references('id')->on('natures')
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
        Schema::dropIfExists('nature_category');
    }
}
