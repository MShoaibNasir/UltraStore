<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxClassesTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_classes_translation', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('tax_class_id')->unsigned();
            $table->string('locale');
            $table->string('name');
			$table->timestamps();
			
            $table->unique(['tax_class_id', 'locale']);
			$table->foreign('tax_class_id')->references('id')->on('tax_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_classes_translation');
    }
}
