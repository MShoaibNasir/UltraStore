<?php

if ( ! function_exists('_lang')){
	function _lang($string=''){
		
		$target_lang = get_language();
				
		if($target_lang == ''){
			$target_lang = "language";
		}
		
		if(file_exists(resource_path() . "/language/$target_lang.php")){
			include(resource_path() . "/language/$target_lang.php"); 
		}else{
			include(resource_path() . "/language/language.php"); 
		}
		
		if (array_key_exists($string,$language)){
			return $language[$string];
		}else{
			return $string;
		}
	}
}


if ( ! function_exists('_dlang')){
	function _dlang( $string = '' ){
		
		//Get Target language
		$target_lang = get_option('language');

		if($target_lang == ''){
			$target_lang = 'language';
		}
		
		if(file_exists(resource_path() . "/language/$target_lang.php")){
			include(resource_path() . "/language/$target_lang.php"); 
		}else{
			include(resource_path() . "/language/language.php"); 
		}
		
		if (array_key_exists( $string, $language )){
			return $language[$string];
		}else{
			return $string;
		}
	}
}


if ( ! function_exists('startsWith')){
	function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
}


if ( ! function_exists('get_initials')){
	function get_initials($string){
		$words = explode(" ", $string);
		$initials = null;
		foreach ($words as $w) {
			 $initials .= $w[0];
		}
		return $initials;
	}
}


if ( ! function_exists('create_option')){
	function create_option($table, $value, $display, $selected='', $where=NULL){
		$options = '';
		$condition = '';
		if($where != NULL){
			$condition .= "WHERE ";
			foreach( $where as $key => $v ){
				$condition.=$key."'".$v."' ";
			}
		}
        
		if (is_array($display)){
		   $display_array =  $display;
		   $display =  $display_array[0];
		   $display1 =  $display_array[1];
		}
		
		$query = DB::select("SELECT * FROM $table $condition");
		foreach($query as $d){
			if( $selected != '' && $selected == $d->$value ){   
				if(! isset($display_array)){
					$options.="<option value='".$d->$value."' selected='true'>".ucwords($d->$display)."</option>";
			    }else{
					$options.="<option value='".$d->$value."' selected='true'>".ucwords($d->$display.' - '.$d->$display1)."</option>";
				}
			}else{
				if(! isset($display_array)){
					$options.="<option value='".$d->$value."'>".ucwords($d->$display)."</option>";
			    }else{
					$options.="<option value='".$d->$value."'>".ucwords($d->$display.' - '.$d->$display1)."</option>";
				}
			} 
		}
		
		echo $options;
	}
}

if ( ! function_exists('object_to_string')){
	function object_to_string($object,$col,$quote = false) 
	{
		$string = "";
		foreach($object as $data){
			if($quote == true){
				$string .="'".$data->$col."', ";
			}else{
				$string .=$data->$col.", ";
			}
		}
		$string = substr_replace($string, "", -2);
		return $string;
	}
}

if ( ! function_exists('get_table')){
	function get_table($table,$where=NULL) 
	{
		$condition = "";
		if($where != NULL){
			$condition .= "WHERE ";
			foreach( $where as $key => $v ){
				$condition.=$key."'".$v."' ";
			}
		}
		$query = DB::select("SELECT * FROM $table $condition");
		return $query;
	}
}


if ( ! function_exists('user_count')){
	function user_count($user_type) 
	{
		$count = \App\User::where("user_type",$user_type)
						->selectRaw("COUNT(id) as total")
						->first()->total;
	    return $count;
	}
}

if ( ! function_exists('has_permission')){
	function has_permission($name) 
	{				
		$permission_list = \Auth::user()->role->permissions;
		$permission = $permission_list->firstWhere('permission', $name);

	    if ( $permission != null ) {
		   return true;
		}
		return false;
	}
}


if ( ! function_exists('get_logo')){
	function get_logo() 
	{
		$logo = get_option("logo");
		if($logo ==""){
			return asset("public/backend/images/company-logo.png");
		}
		return asset("public/uploads/media/$logo"); 
	}
}

if ( ! function_exists('get_favicon')){
	function get_favicon() 
	{
		$favicon = get_option("favicon");
		if($favicon == ""){
			return asset("public/backend/images/favicon.png");
		}
		return asset("public/uploads/media/$favicon"); 
	}
}

if ( ! function_exists('profile_picture')){
	function profile_picture($profile_picture = '') 
	{
		if($profile_picture == ''){
			$profile_picture = Auth::user()->profile_picture;
		}
		
        if($profile_picture == ''){
			return asset('public/backend/images/avatar.png');
		}	
        
		return asset('public/uploads/profile/' . $profile_picture);		
	}
}


if ( ! function_exists('sql_escape')){
	function sql_escape($unsafe_str) 
	{
		if (get_magic_quotes_gpc())
		{
			$unsafe_str = stripslashes($unsafe_str);
		}
		return $escaped_str = str_replace("'", "", $unsafe_str);
	}
}


if ( ! function_exists('get_option')){
	function get_option($name, $optional = '' ) 
	{
		$value = Cache::get($name); 
		
		if($value == "" || $value == NULL){
			$setting = DB::table('settings')->where('name', $name)->get();
			if ( ! $setting->isEmpty() ) {
			    $value = $setting[0]->value;   
			    
			    if(json_decode($value) === null) {
			    	Cache::put($name, $value);
			    }else{
			    	$value = json_decode($value);
					Cache::put($name, $value);
			    }
				
			}else{
				$value = $optional;
				Cache::put($name, $value);
			}
		}
		return $value;

	}
}

if ( ! function_exists('get_trans_option')){
	function get_trans_option($name, $optional = '') 
	{	
		$value = Cache::get($name."-".get_language()); 

		if($value == "" || $value == NULL){
			$setting = \App\Setting::where('name', $name)->first();

			if ( $setting ) {
			    $value = $setting->translation->value; 
			    Cache::put($name."-".get_language(), $value);  				
			}else{
				$value = $optional;
				Cache::put($name."-".get_language(), $value);
			}
		}
		
		return $value;
	}
}

if ( ! function_exists('get_setting')){
	function get_setting($settings, $name, $optional = '' ) 
	{
		$row = $settings->firstWhere('name', $name);
	    if ( $row != null ) {
		   return $row->value;
		}
		return $optional;

	}
}

if ( ! function_exists('get_array_option')){
	function get_array_option($name, $key = '', $optional = '' ) 
	{
		if($key == ''){
			if(session('language') == ''){		
				$key = get_option('language');
                session(['language' => $key]);
			}else{
				$key = session('language');
			}
		}
		$setting = DB::table('settings')->where('name', $name)->get();
	    if ( ! $setting->isEmpty() ) {

		   $value =  $setting[0]->value;
		   if(@unserialize($value) !== false){
		   	   $value =  @unserialize($setting[0]->value);

		   	   return isset($value[$key]) ? $value[$key] : $value[array_key_first($value)];
		   }

		   return $value;
		}
		return $optional;

	}
}

if ( ! function_exists('get_array_data')){
	function get_array_data($data, $key = '') 
	{
       if($key == ''){
			if(session('language') == ''){	
				$key = get_option('language');
                session(['language' => $key]);
			}else{
				$key = session('language');
			}
		}
		
	   if(@unserialize($data) !== false){
	   	   $value =  @unserialize($data);
	   	   return isset($value[$key]) ? $value[$key] : $value[array_key_first($value)];
	   }

	   return $data;

	}
}


if ( ! function_exists('update_option')){
	function update_option($name, $value) 
	{
		date_default_timezone_set(get_option('timezone','Asia/Dhaka'));
		
	    $data = array();
		$data['value'] = $value; 
		$data['updated_at'] = \Carbon\Carbon::now();
		if(\App\Setting::where('name', $name)->exists()){				
			\App\Setting::where('name', $name)->update($data);			
		}else{
			$data['name'] = $name; 
			$data['created_at'] = \Carbon\Carbon::now();
			\App\Setting::insert($data); 
		}
		\Cache::put($name, $value);
	}
}


if ( ! function_exists('timezone_list'))
{

 function timezone_list() {
  $zones_array = array();
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
    $zones_array[$key]['ZONE'] = $zone;
    $zones_array[$key]['GMT'] = 'UTC/GMT ' . date('P', $timestamp);
  }
  return $zones_array;
}

}

if ( ! function_exists('create_timezone_option'))
{

 function create_timezone_option($old="") {
  $option = "";
  $timestamp = time();
  foreach(timezone_identifiers_list() as $key => $zone) {
    date_default_timezone_set($zone);
	$selected = $old == $zone ? "selected" : "";
	$option .= '<option value="'. $zone .'"'.$selected.'>'. 'GMT ' . date('P', $timestamp) .' '.$zone.'</option>';
  }
  echo $option;
}

}


if ( ! function_exists( 'get_country_list' ))
{
    function get_country_list( $old_data='' ) {
		if( $old_data == '' ){
			echo file_get_contents( app_path().'/Helpers/country.txt' );
		}else{
			$pattern='<option value="'.$old_data.'">';
			$replace='<option value="'.$old_data.'" selected="selected">';
			$country_list=file_get_contents( app_path().'/Helpers/country.txt' );
			$country_list=str_replace($pattern,$replace,$country_list);
			echo $country_list;
		}
    }	
}

if ( ! function_exists('show_price'))
{
	function show_price($amount, $show_symbol = true){
		
		$currency = session('currency') =='' ? currency() : session('currency');
		//$currency = \Cache::get('currency') =='' ? currency() : \Cache::get('currency');
		
		$base_rate =\Cache::get('base_rate');
		//$display_currency_rate = \Cache::get('display_currency_rate');
		$display_currency_rate = session('display_currency_rate');


  		if($base_rate == ''){
			$base_rate = \App\Currency::where('name',currency())->first()->exchange_rate;
			\Cache::put('base_rate', $base_rate);
		}

		if($display_currency_rate == ''){
			$display_currency_rate = \App\Currency::where('name',$currency)->first()->exchange_rate;
			session(['display_currency_rate' => $display_currency_rate]);
			//\Cache::put('display_currency_rate', $display_currency_rate);
		}

		$amount = convert_currency_2($base_rate, $display_currency_rate, $amount);
		
		if($show_symbol == true){
			if(get_currency_position() == 'right'){	
				return money_format_2( $amount ).' '.get_currency_symbol($currency);	
			}else{
				return get_currency_symbol($currency).' '.money_format_2( $amount );
			}
		}

		return $amount;			
	}
}


if ( ! function_exists('decimalPlace'))
{
	function decimalPlace($number, $symbol = ''){
		
		if($symbol == ''){
			return money_format_2( $number );
		}
			
		if(get_currency_position() == 'right'){	
			return money_format_2( $number ).' '.get_currency_symbol($symbol);	
		}else{
			return get_currency_symbol($symbol).' '.money_format_2( $number );
		}
		
	}
}


if (!function_exists('money_format_2')) {
	function money_format_2($floatcurr){
		$decimal_place = get_option('decimal_places',2);
		$decimal_sep = get_option('decimal_sep','.');
		$thousand_sep = get_option('thousand_sep',',');

		return number_format($floatcurr, $decimal_place, $decimal_sep, $thousand_sep);	
	}
}

if( !function_exists('formatinr') ){
	// custom function to generate: ##,##,###.##
	function formatinr($input)
	{
		$dec = "";
		$pos = strpos($input, ".");
		if ($pos === FALSE)
		{
			//no decimals
		}
		else
		{
			//decimals
			$dec   = substr(round(substr($input, $pos), 2), 1);
			$input = substr($input, 0, $pos);
		}
		$num   = substr($input, -3);    // get the last 3 digits
		$input = substr($input, 0, -3); // omit the last 3 digits already stored in $num
		// loop the process - further get digits 2 by 2
		while (strlen($input) > 0)
		{
			$num   = substr($input, -2).",".$num;
			$input = substr($input, 0, -2);
		}
		return $num.$dec;
	}
}

if( !function_exists('load_language') ){
	function load_language($active=''){
		$path = resource_path() . "/language";
		$files = scandir($path);
		$options="";
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == "" || $name == "language"){
				continue;
			}
			
			$selected = "";
			if($active == $name){
				$selected = "selected";
			}else{
				$selected = "";
			}
			
			$options .= "<option value='$name' $selected>".$name."</option>";
		        
		}
		echo $options;
	}
}

if( !function_exists('get_language_list') ){
	function get_language_list(){
		$path = resource_path() . "/language";
		$files = scandir($path);
		$array = array();
		
		foreach($files as $file){
		    $name = pathinfo($file, PATHINFO_FILENAME);
			if($name == "." || $name == "" || $name == "language" || $name == "flags"){
				continue;
			}
	
			$array[] = $name;
		        
		}
		return $array;
	}
}

if( !function_exists('process_string') ){

	function process_string($search_replace, $string){
	   	$result = $string;
	   	foreach($search_replace as $key=>$value){
			$result = str_replace($key, $value, $result);
	   	}
	   	return $result;
	}

}


if ( ! function_exists('permission_list')){
	function permission_list()
	{
		  
		$permission_list =  \App\AccessControl::where("role_id", Auth::user()->role_id)
											  ->pluck('permission')->toArray();	
	    return $permission_list;
	}
}


if ( ! function_exists( 'get_currency_list' ))
{
	function get_currency_list( $old_data='', $serialize = false ) {	
		$currency_list = file_get_contents( app_path().'/Helpers/currency.txt' );
		
		if( $old_data == "" ){
			echo $currency_list;
		}else{
			if($serialize == true){
				$old_data = unserialize($old_data);
				for($i=0; $i<count($old_data); $i++){
					$pattern = '<option value="'.$old_data[$i].'">';
					$replace = '<option value="'.$old_data[$i].'" selected="selected">';
				    $currency_list = str_replace($pattern,$replace,$currency_list);
				}
				echo $currency_list;
			}else{
				$pattern = '<option value="'.$old_data.'">';
				$replace = '<option value="'.$old_data.'" selected="selected">';
				$currency_list = str_replace($pattern,$replace,$currency_list);
				echo $currency_list;
			}
		}
	}	
}

if ( ! function_exists( 'get_currency_symbol' ))
{
	function get_currency_symbol( $currency_code ) {
		include(app_path().'/Helpers/currency_symbol.php');
        
		if (array_key_exists($currency_code, $currency_symbols)){
			return $currency_symbols[$currency_code];
		}
		return $currency_code;
		
	}
}	


if ( ! function_exists('status')){
	function status($status)
	{
		if($status == 1){
			return "<span class='badge badge-success'>". _lang('Active') ."</span>"; 
		}else if($status == 0){
			return "<span class='badge badge-danger'>". _lang('In Active') ."</span>"; 
		}
	}
}


if ( ! function_exists('file_icon')){
	function file_icon($mime_type)
    {
        static $font_awesome_file_icon_classes = [
            // Images
            'image'=> 'fa-file-image',
            // Audio
            'audio'=> 'fa-file-audio',
            // Video
            'video'=> 'fa-file-video',
            // Documents
            'application/pdf'=> 'fa-file-pdf',
            'application/msword'=> 'fa-file-word',
            'application/vnd.ms-word'=> 'fa-file-word',
            'application/vnd.oasis.opendocument.text'=> 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml'=> 'fa-file-word',
            'application/vnd.ms-excel'=> 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml'=> 'fa-file-excel',
            'application/vnd.oasis.opendocument.spreadsheet'=> 'fa-file-excel',
            'application/vnd.ms-powerpoint'=> 'fa-file-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml'=> 'ffa-file-powerpoint',
            'application/vnd.oasis.opendocument.presentation'=> 'fa-file-powerpoint',
            'text/plain'=> 'fa-file-alt',
            'text/html'=> 'fa-file-code',
            'application/json'=> 'fa-file-code',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=> 'fa-file-word',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=> 'fa-file-excel',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation'=> 'fa-file-powerpoint',
            // Archives
            'application/gzip'=> 'fa-file-archive',
            'application/zip'=> 'fa-file-archive',
            'application/x-zip-compressed'=> 'fa-file-archive',
            // Misc
            'application/octet-stream'=> 'fa-file-archive',
        ];

        if (isset($font_awesome_file_icon_classes[$mime_type]))
            return $font_awesome_file_icon_classes[$mime_type];

        $mime_group = explode('/', $mime_type, 2)[0];
        return (isset($font_awesome_file_icon_classes[$mime_group])) ? $font_awesome_file_icon_classes[$mime_group] : 'fa-file';
    }
}


if ( ! function_exists('update_currency_exchange_rate')){
	function update_currency_exchange_rate($force = false)
	{
		if(get_option('currency_converter') != 'fixer'){
			return false;
		}
			
		date_default_timezone_set(get_option('timezone','Asia/Dhaka'));

		$start  = new \Carbon\Carbon( get_option('currency_update_time',date("Y-m-d H:i:s", strtotime('-24 hours', time())) ) );
		$end    = \Carbon\Carbon::now();
  
		$last_run = $start->diffInHours($end);
		
		if( $last_run >= 12  || $force == true){
			// Set API Endpoint and API key 
			$endpoint = 'latest';
			$access_key = get_option('fixer_api_key');

			// Initialize CURL:
			$ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key.'');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// Store the data:
			$json = curl_exec($ch);
			curl_close($ch);

			// Decode JSON response:
			$exchangeRates = json_decode($json, true);

			if($exchangeRates['success'] == false){
				return false;
			}

			$currency_list = \App\Currency::all();
			$system_base_currency = get_base_currency();
			//$fixer_base_currency =  $exchangeRates['base'];


			DB::beginTransaction();
			
			foreach($currency_list as $currency){
				if(isset($exchangeRates['rates'][$currency->name])){

					if($currency->	base_currency == 1){
						continue;
					}
	
					$rate = $exchangeRates['rates'][$currency->name] / $exchangeRates['rates'][$system_base_currency];			
					$currency->exchange_rate = $rate;
					$currency->save();
				}
				
			}

			//Store Last Update time
			update_option("currency_update_time", \Carbon\Carbon::now());

			DB::commit();
		}
	}
}

if ( ! function_exists('convert_currency'))
{
    function convert_currency($from_currency, $to_currency, $amount){
		$currency1 = \App\Currency::where('name',$from_currency)->first()->exchange_rate;
		$currency2 = \App\Currency::where('name',$to_currency)->first()->exchange_rate;

		$converted_output = ($amount/$currency1) * $currency2;
        return $converted_output;
    }
}

if ( ! function_exists('convert_currency_2'))
{
    function convert_currency_2($currency1_rate, $currency2_rate, $amount){
		$currency1 = $currency1_rate;
		$currency2 = $currency2_rate;

		$converted_output = ($amount/$currency1) * $currency2;
        return $converted_output;
    }
}

if ( ! function_exists('cartesian')){
	function cartesian($input) {
	    $result = array(array());

	    foreach ($input as $key => $values) {
	        $append = array();

	        foreach($result as $product) {
	            foreach($values as $item) {
	                $product[$key] = $item;
	                $append[] = $product;
	            }
	        }

	        $result = $append;
	    }

	    return $result;
	}
}

/** Get variation price **/
if ( ! function_exists('get_variation_price')){
	function get_variation_price($product_id, $product_options, $symbol = false){

	    $variationPrices = \App\Entity\Product\ProductVariationPrice::where('product_id',$product_id)->get();

	    $price = "";
	    $special_price = "";
	    $attributes = array();
	    
	    foreach($variationPrices as $variation_price){
	        $variation_items = array();
	        $variations = array();

	        foreach(json_decode($variation_price->option) as $option){
	            array_push($variation_items, $option->id);
	            array_push($variations, $option->variation_id);
	        }

	        $result = array_diff($variation_items, $product_options);
	        
	        if(empty($result)){
 				$variation_items = \App\Entity\Product\ProductVariationItem::whereIn('id',$product_options)->get();
 				foreach($variation_items as $vi){
 					$attributes[$vi->variation->name] = $vi->name;
 				}

		        if($symbol == true){
		            $price = show_price($variation_price->price);
		            $special_price = $variation_price->special_price != '' ? show_price($variation_price->special_price) : '';
		            break;
		        }else if($symbol == false){
					$price = $variation_price->price;
		            $special_price = $variation_price->special_price != '' ? $variation_price->special_price : '';
		            break;
		        }
		    }
	    }

	    if($price == "" && $special_price == ""){
	        return array(
		                'result'        => false,
		                'price'         => $price,
		                'special_price' => $special_price,
		                'attributes'	=> $attributes,
	            	);
	    }else{
	        return array(
		                'result'        => true,
		                'price'         => $price,
		                'special_price' => $special_price,
		                'attributes'	=> $attributes,
	            	);
	    } 

	}
}



if ( ! function_exists('xss_clean')){
	function xss_clean($data)
	{
		// Fix &entity\n;
		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		do
		{
		    // Remove really unwanted tags
		    $old_data = $data;
		    $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);

		// we are done...
		return $data;
	}
}


// convert seconds into time
if ( ! function_exists('time_from_seconds')){
	function time_from_seconds($seconds) { 
	    $h = floor($seconds / 3600); 
	    $m = floor(($seconds % 3600) / 60); 
	    $s = $seconds - ($h * 3600) - ($m * 60); 
	    return sprintf('%02d:%02d:%02d', $h, $m, $s); 
	} 
}

if ( ! function_exists('get_all_country')){
	function get_all_country() { 
	    $data = json_decode(file_get_contents( app_path().'/Helpers/countries.json' ));
		$collection = collect( $data->countries );
		return $collection->all();	
	} 
}


if ( ! function_exists('get_country_id')){
	function get_country_id($shortcode) { 
	    $data = json_decode(file_get_contents( app_path().'/Helpers/countries.json' ));
		$collection = collect( $data->countries );
		
		$filtered = $collection->where('sortname', $shortcode);
		return $filtered->first()->id;	
	} 
}

if ( ! function_exists('get_states')){
	function get_states($country_id) { 
	    $data = json_decode(file_get_contents( app_path().'/Helpers/states.json' ));
		$collection = collect( $data->states );
		
		$filtered = $collection->where('country_id', $country_id);
		return $filtered->all();	
	} 
}

if ( ! function_exists('navigationTree')){
	
    function navigationTree($object, $currentParent, $controller, $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $menu) {
			if ($currentParent == $menu->parent_id) {
				if ($currLevel > $prevLevel) echo "<ol id='menutree' class='dd-list'>"; 
				if ($currLevel == $prevLevel) echo "</li>";

				echo '<li class="dd-item" data-id="'.$menu->id.'"><div class="dd-handle">'.$menu->translation->name.'</div><a class="edit_menu" href="'.action("$controller@edit", $menu->id).'"><i class="far fa-edit"></i></a>
					<a class="btn-remove-2 remove_menu" href="'.action("$controller@destroy", $menu->id).'"><i class="far fa-trash-alt"></i></a>';
					if ($currLevel > $prevLevel) { 
					   $prevLevel = $currLevel; 
					}
				$currLevel++; 
				navigationTree($object, $menu->id, $controller, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ol>";
	 }
}

if ( ! function_exists('buildTable')){
	
	function buildTable($object, $currentParent, $url, $currLevel = 0, $prevLevel = -1) {
		foreach ($object as $category) {
			if ($currentParent == $category->parent_id) {

				$level ="";
				for($i=0; $i<$currLevel; $i++){
					$level .="-";
				}
				echo '<tr>';
				echo '<td>'.$category->id.'</td>';
				echo '<td>'.$level." ".$category->category_name.'</td>';
				echo '<td>'.$category->slug.'</td>';
				echo 
				'<td>'.
				'<form action="'.route($url.".destroy",$category->id).'" method="post">
				<a href="'.route($url.".edit",$category->id).'" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				'.method_field("DELETE").'
				'.csrf_field().'
				<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
				</form>'
				.'</td>';
				echo '</tr>';
				if ($currLevel > $prevLevel) { 
					$prevLevel = $currLevel; 
				}
				$currLevel++; 
				buildTable ($object, $category->id, $url, $currLevel, $prevLevel);
				$currLevel--;   
			}
		}
	}
}


if ( ! function_exists('buildOptionTree')){

	function buildOptionTree($object, $currentParent, $notshowing = null, $currLevel = 0, $prevLevel = -1, $maxLevel = 10) {

		foreach ($object as $category) {
			if ($currentParent == $category->parent_id) {
				if($notshowing != $category->id){
					$level = "";

					if($currLevel > $maxLevel){
						break;
					}

					for($i = 0; $i < $currLevel; $i++){
						$level .= "-";
					}

					echo '<option value="'.$category->id.'">'.$level. ' ' . $category->translation->name . '</option>';
					
					if ($currLevel > $prevLevel) { 
						$prevLevel = $currLevel; 
					}

					$currLevel++; 

					buildOptionTree ($object, $category->id, $notshowing, $currLevel, $prevLevel, $maxLevel);

					$currLevel--;   
				}
			}
		}
	}
}

if ( ! function_exists('buildTree')){
	
    function buildTree($object, $currentParent, $url, $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $category) {
			if ($currentParent == $category->parent_id) {

				if ($currLevel > $prevLevel) echo "<ul class='menutree'>"; 
				if ($currLevel == $prevLevel) echo "</li>";

				echo '<li> <label class="menu_label" for='.$category->id.'>
				<a href="'.route($url.".edit", $category->id).'">'. $category->translation->name .'</a></label>';
				
				if ($currLevel > $prevLevel) { 
				   $prevLevel = $currLevel; 
				}

				$currLevel++; 
				buildTree ($object, $category->id, $url, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ul>";
	 }
}

if ( ! function_exists('buildTreeCollapse')){
	
    function buildTreeCollapse($object, $currentParent, $url, $active ='', $currLevel = 0, $prevLevel = -1) {
		 foreach ($object as $category) {
			if ($currentParent == $category->parent_id) {

				if ($currLevel > $prevLevel) {
					if($category->parent_id != null){
						echo "<ul class='categor-list collapse' id='category-". $category->parent_id ."'>"; 
					}else{
						echo "<ul class='categor-list'>";
					}
					
				}
					
				if ($currLevel == $prevLevel) echo "</li>";

				if($category->child_category->count() > 0){
					echo '<li>
					<i class="fa fa-angle-right" role="button" aria-hidden="true" data-toggle="collapse" data-target="#category-'. $category->id .'" aria-expanded="false" aria-controls="category-'. $category->id .'"></i>&nbsp;&nbsp;

					<a class="'.($active == $category->slug ? 'active' : '').'" href="'.filter_url($url ."/". $category->slug).'">'. $category->translation->name .'</a>';
				}else{
					echo '<li>
					<a class="'.($active == $category->slug ? 'active' : '').'" href="'.filter_url($url ."/". $category->slug).'">'. $category->translation->name .'</a>';
				}

				if ($currLevel > $prevLevel) { 
				   $prevLevel = $currLevel; 
				}

				$currLevel++; 
				buildTreeCollapse ($object, $category->id, $url, $active,  $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ul>";
	 }
}


if( !function_exists('load_custom_template') ){
	function load_custom_template(){
		$path = resource_path() . "/views/theme/default/templates";
		if( is_dir($path) ){
			$files = scandir($path);
			$options = "";
			foreach($files as $file){
			   $name = pathinfo($file, PATHINFO_FILENAME);
			   if ( strpos($name, 'template-') === 0) {   
				   $name = str_replace(".blade","",substr($name,9));
				   $options .= "<option value='$name'>".ucwords($name)."</option>";
			   }			        
			}
			echo $options;
		}
	}
}

if ( ! function_exists('show_navigation')){
	function show_navigation($nav_id, $main_class= '', $dp_1_class= '', $dp_2_class= '', $icon_type = 'down') { 

	    $navigation = \App\Entity\Navigation\Navigation::where('id', $nav_id)
	    											   ->where('status',1)->first();
	    if( $navigation ){										   
		    $navigation_items = $navigation->navigationItems()->where('status',1)->get();
			buildNavigation($navigation_items, $main_class, $dp_1_class, $dp_2_class, $icon_type);
		}
   
	} 
}

if ( ! function_exists('buildNavigation')){
	
    function buildNavigation($navigation_items, $main_class= '', $dropdown_1_class= '', $dropdown_2_class= '', $icon_type = '', $currentParent = 0, $currLevel = 0, $prevLevel = -1) {
		 foreach ($navigation_items as $nav_item) {
			if ($currentParent == $nav_item->parent_id) {

				if($currLevel > $prevLevel && $currLevel == 0){
					echo "<ul class='$main_class'>";
				}else if ($currLevel > $prevLevel && $currLevel == 1) {
					echo "<ul class='$dropdown_1_class'>"; 
				}else if ($currLevel > $prevLevel && $currLevel == 2) {
					echo "<ul class='$dropdown_2_class'>"; 
				}

				if ($currLevel == $prevLevel) echo "</li>";

				if($nav_item->type == 'dynamic_url'){
					$url = url($nav_item->url);
				}else if($nav_item->type == 'page'){
					$url = url('/'.$nav_item->page->slug);
				}else if($nav_item->type == 'category'){
					$url = url('/categories/'.$nav_item->category->slug);
				}else if($nav_item->type == 'custom_url'){
					$url = $nav_item->url;
				}

				$icon = $nav_item->icon;
				$target = $nav_item->target;
				$css_class = $nav_item->css_class != '' ? "class='$nav_item->css_class'" : "";
				$css_id = $nav_item->css_id != '' ? "id='$nav_item->css_id'" : "";

				$has_child = '';

				if($nav_item->child_items->count() > 0 && $currLevel == 0){
					$has_child = $icon_type == 'down' ? ' <i class="fa fa-angle-down"></i>' : ' <i class="fa fa-angle-right"></i>';
				}else if($nav_item->child_items->count() > 0 && $currLevel == 1){
					$has_child = ' <i class="fa fa-angle-right"></i>';
				}

				echo '<li><a target="'. $target .'" href="' . $url . '" '.$css_class.' '.$css_id.'>'. $icon .' '. $nav_item->translation->name .' '.$has_child.'</a>';
				
				if ($currLevel > $prevLevel) { 
				   $prevLevel = $currLevel; 
				}

				$currLevel++; 
				buildNavigation ($navigation_items, $main_class, $dropdown_1_class, $dropdown_2_class, $icon_type,  $nav_item->id, $currLevel, $prevLevel);
				$currLevel--;   
			}
		 }
		if ($currLevel == $prevLevel) echo "</li> </ul>";
	 }
}

if ( ! function_exists('wishlist_url')){
	function wishlist_url($product) { 
	    if(! \Auth::check()){
	    	return url('sign_in');
	    }
	    return url('wish_list/'.$product->id);
	} 
}

/* Shop Page Functions */
if ( ! function_exists('filter_url')){
	function filter_url($url) { 
		$length = isset($_GET['length']) ? $_GET['length'] : '';
		$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';

		if($length == '' && $sort_by == ''){
			return url($url);
		}

	    return url($url."?length=$length&sort_by=$sort_by");
	} 
}

/* End Shop Page functions */

if ( ! function_exists('show_admin_comment')){

	function show_admin_comment($comment) {
		echo '<ul class="menutree">';

		echo '<li><span class="menu_label">'. $comment->body .'<a href="'. route('product_comments.destroy', $comment->id) .'" class="text-danger float-right btn-remove-2"><i class="fas fa-eraser"></i></a></span>';
		
		if($comment->replies->count() > 0){
			foreach($comment->replies as $replies){
				show_admin_comment($replies);
    		}
		}

	    echo '</li></ul>';
	} 
}

if ( ! function_exists('show_rating')){
	function show_rating($rating, $element = 'li') {
		$html = ''; 
	    for($i = 1; $i <= $rating; $i++){
	    	if($element == 'li'){
	    		$html .= '<li><i class="fa fa-star"></i></li>';
	    	}else if($element == 'i'){
	    		$html .= '<i class="fa fa-star"></i>';
	    	}	
	    }

	    for($i = 0; $i < (5 - $rating); $i++){
			if($element == 'li'){
				$html .= '<li><i class="fa fa-star-o"></i></li>';
			}else if($element == 'i'){
				$html .= '<i class="fa fa-star-o"></i>';
			}
	    }

	    return $html;
	} 
}


if ( ! function_exists('get_max_price')){
	function get_max_price()
	{
		$general_product_price = \App\Entity\Product\Product::where('is_active', 1)
				  									  ->max('price');
		$variable_product_price = \App\Entity\Product\ProductVariationPrice::max('price');	

		if($variable_product_price > $general_product_price){
			return $variable_product_price;
		}
		return $general_product_price;		  							
	}
}


/* Intelligent Functions */
if ( ! function_exists('get_language')){
	function get_language() { 

	    $language = session('language');
	    
	    if($language == ''){
	    	$language = Cache::get('language'); 
		}

		if($language == ''){	
			$language = get_option('language');
			if($language == ''){
			    \Cache::put('language', 'language');
			}else{
				\Cache::put('language', $language);
			}
			
		}
		
		return $language;
	} 
}

if ( ! function_exists('get_currency_position')){
	function get_currency_position() { 
	    $currency_position = Cache::get('currency_position'); 
		
		if($currency_position == ''){	
			$currency_position = get_option('currency_position');
			\Cache::put('currency_position', $currency_position);
		}
		
		return $currency_position;
	} 
}

if ( ! function_exists('currency')){
	function currency() { 
	    $currency = Cache::get('currency'); 
		
		if($currency == ''){	
			$currency = get_base_currency();
			\Cache::put('currency', $currency);
		}	
		return $currency;
	} 
}

if ( ! function_exists('get_base_currency')){
	function get_base_currency() 
	{
		$currency = \App\Currency::where("base_currency",1)->first();
		if(! $currency){
			$currency = \App\Currency::all()->first();
		}
	    return $currency->name;
	}
}

if ( ! function_exists('get_date_format')){
	function get_date_format() { 
	    $date_format = Cache::get('date_format'); 
		
		if($date_format == ''){	
			$date_format = get_option('date_format');
			\Cache::put('date_format', $date_format);
		}
		
		return $date_format;
	} 
}

if ( ! function_exists('get_time_format')){
	function get_time_format() { 
	    $time_format = Cache::get('time_format'); 
		
		if($time_format == ''){	
			$time_format = get_option('time_format');
			\Cache::put('time_format', $time_format);
		}
		
		$time_format = $time_format == 24 ? 'H:i' : 'h:i A';
		
		return $time_format;
	} 
}
