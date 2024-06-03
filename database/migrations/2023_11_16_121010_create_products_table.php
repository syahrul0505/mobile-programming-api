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
            $table->id();
            $table->string("name");
            $table->string("category")->nullable();
            $table->float("purchase_price")->nullable();
            $table->float("selling_price")->nullable();
            $table->string("status")->nullable();
            $table->text("image")->nullable();
            $table->string("code")->nullable();
            $table->bigInteger("stock_per_day")->nullable();
            $table->bigInteger("current_stock")->nullable();
            $table->string("description")->nullable();
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
        Schema::dropIfExists('products');
    }
}
