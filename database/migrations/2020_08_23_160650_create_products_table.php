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
			$table->bigInteger('brand_id')->unsigned()->nullable();
			$table->bigInteger('tax_class_id')->unsigned()->nullable();
            $table->string('slug')->unique();
			$table->string('product_type');
            $table->decimal('price', 10, 2)->unsigned();
            $table->decimal('special_price', 10, 2)->unsigned()->nullable();
            $table->date('special_price_start')->nullable();
            $table->date('special_price_end')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('manage_stock');
            $table->bigInteger('qty')->nullable();
            $table->boolean('in_stock');
            $table->bigInteger('viewed')->unsigned()->default(0);
            $table->boolean('is_active');
            $table->string('featured_tag',30)->nullable();
            $table->text('digital_file')->nullable();
            $table->timestamps();
			
			$table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
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
