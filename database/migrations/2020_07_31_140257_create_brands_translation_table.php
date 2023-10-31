<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands_translation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id')->unsigned();
            $table->string('locale');
            $table->string('name');
			$table->timestamps();
			
            $table->unique(['brand_id', 'locale']);
			$table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands_translation');
    }
}
