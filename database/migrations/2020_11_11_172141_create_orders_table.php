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
            $table->bigInteger('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
			$table->string('customer_phone');
            $table->string('billing_name');
            $table->string('billing_city')->nullable();
            $table->string('billing_state');
            $table->string('billing_post_code');
            $table->string('billing_country');
			$table->text('billing_address');
            $table->string('shipping_name');
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state');
            $table->string('shipping_post_code');
            $table->string('shipping_country');
			$table->text('shipping_address');
            $table->decimal('sub_total', 10, 2)->unsigned();
            $table->string('shipping_method');
            $table->decimal('shipping_cost', 10, 2)->unsigned();
            $table->bigInteger('coupon_id')->nullable();
            $table->decimal('discount', 10, 2)->unsigned();
            $table->decimal('total', 10, 2)->unsigned();
            $table->string('payment_method')->nullable();
            $table->string('currency');
            $table->decimal('currency_rate', 10, 2);
            $table->string('locale');
            $table->string('status',30);
            $table->text('note')->nullable();
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
