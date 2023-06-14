<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PackProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_product', function (Blueprint $table) {

            $table->unsignedBigInteger('pack_id');

            $table->unsignedBigInteger('product_id');

            $table->foreign('pack_id')->references('id')->on('packs')
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
        Schema::dropIfExists('pack_product');
    }
}
