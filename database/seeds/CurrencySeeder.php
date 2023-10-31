<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert([
			[
				'name' 			=> 'USD',
				'base_currency' => 1,
				'exchange_rate' => 1.00,
				'status' 		=> 1,
			],[
				'name' 			=> 'EUR',
				'base_currency' => 0,
				'exchange_rate' => 0.85,
				'status' 		=> 1,
			],[
				'name' 			=> 'INR',
				'base_currency' => 0,
				'exchange_rate' => 72.45,
				'status' 		=> 1,
			]
		]);
		
		//Default Settings
		DB::table('settings')->insert([
			[
			  'name' => 'mail_type',
			  'value' => 'smtp'
			],
			[
			  'name' => 'backend_direction',
			  'value' => 'ltr'
			],	
			[
			  'name' => 'language',
			  'value' => 'English'
			],
			[
			  'name' => 'email_verification',
			  'value' => 'disabled'
			],
		]);
    }
}
