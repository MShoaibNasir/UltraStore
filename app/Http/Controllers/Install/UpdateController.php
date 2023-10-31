<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Utilities\Installer;
use Artisan;



class UpdateController extends Controller
{	

	public function __construct(){}
	
	public function update_migration(){
		Artisan::call('migrate', ['--force' => true]);
		Installer::updateEnv([
            'APP_VERSION' =>  '1.2',
        ]);
		echo "Migration Updated Sucessfully";
	} 
}
