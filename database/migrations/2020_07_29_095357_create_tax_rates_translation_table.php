<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxRatesTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rates_translation', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('tax_rate_id')->unsigned();
            $table->string('locale');
            $table->string('name');
			$table->timestamps();
			
            $table->unique(['tax_rate_id', 'locale']);
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
        Schema::dropIfExists('tax_rates_translation');
    }
}
