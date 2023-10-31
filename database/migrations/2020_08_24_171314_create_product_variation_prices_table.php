<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_prices', function (Blueprint $table) {
            $table->id();
			$table->bigInteger('product_id')->unsigned();
			$table->text('option');
			$table->decimal('price',10,2);
            $table->decimal('special_price',10,2)->unsigned()->nullable();
			$table->boolean('is_available');
			
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_prices');
    }
}
