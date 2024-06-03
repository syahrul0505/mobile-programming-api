<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->float('sub_total')->nullable();
            $table->float('total_price')->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('status_pesanan')->nullable();
            $table->string('category')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('status_realtime')->nullable();
            $table->float('pb01')->nullable();
            $table->float('service')->nullable();
            $table->text('token')->nullable();

            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
