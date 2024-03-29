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
            $table->string('order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('appoinment')->nullable();
            $table->string('datetime')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('order_status')->nullable();
            $table->string('order_amount')->nullable();
            $table->longText('order_response')->nullable();
            $table->longText('cancel_order_reason')->nullable();
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
