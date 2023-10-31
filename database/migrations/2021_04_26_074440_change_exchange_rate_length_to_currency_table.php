<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeExchangeRateLengthToCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currency', function (Blueprint $table) {
			DB::statement('ALTER TABLE currency MODIFY COLUMN exchange_rate decimal(10,6)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currency', function (Blueprint $table) {
            DB::statement('ALTER TABLE currency MODIFY COLUMN exchange_rate decimal(10,2)');
        });
    }
}
