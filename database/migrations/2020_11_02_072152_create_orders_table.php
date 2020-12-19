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
            $table->id('order_id');
            $table->string('invoice_number');
            $table->unsignedBigInteger('cust_id');
            $table->string('discount_type');
            $table->float('discount_amount')->default('0');
            $table->float('sub_total')
            $table->float('total');
            $table->float('due');
            $table->string('status');
            $table->timestamps();
            $table->foreign('cust_id')->references('cust_id')->on('customers')->onDelete('cascade');
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
