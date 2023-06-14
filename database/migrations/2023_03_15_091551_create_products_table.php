<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->enum('type', ['standard', 'service']);
            $table->string('barcode_symbology')->nullable();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('sub_nature_id')->nullable();
            $table->unsignedBigInteger('nature_id')->nullable();
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('purchase_unit_id')->nullable();
            $table->bigInteger('sale_unit_id')->nullable();
            $table->bigInteger('tax_id')->nullable();
            $table->bigInteger('tax_method')->nullable();

            $table->double('cost');
            $table->double('price');
            $table->integer('qty')->nullable();
            $table->integer('alert_quantity')->nullable();
            $table->longText('image')->nullable();
            // $table->tinyInteger('featured')->nullable();
            $table->text('product_details')->nullable();
            $table->boolean('is_active')->nullable();

            $table->foreign('product_category_id')->references('id')->on('product_categories');
            $table->foreign('nature_id')->references('id')->on('natures');
            $table->foreign('sub_nature_id')->references('id')->on('sub_natures');
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
        Schema::dropIfExists('products');
    }
}
