<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_taxes', function (Blueprint $table) {
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('tax_rate_id')->unsigned();
            $table->decimal('amount', 15, 4)->unsigned();
			
			$table->primary(['order_id', 'tax_rate_id']);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('tax_rate_id')->references('id')->on('tax_rates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_taxes');
    }
}
