<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('order_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->text('product_attributes')->nullable();
            $table->decimal('unit_price', 10, 2)->unsigned();
            $table->integer('qty');
            $table->decimal('line_total', 10, 2)->unsigned();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
