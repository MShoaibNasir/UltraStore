<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Entity\Product\Product;
use App\Entity\Product\ProductTranslation;
use App\Entity\Product\ProductVariationPrice;
use Validator;
use DataTables;
use DB;

class ProductController extends Controller
{
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set(get_option('timezone','Asia/Dhaka'));
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.product.list');
    }
	
	public function get_table_data(){
		
		$products = Product::select('products.*')
                           ->with('translation')
                           ->with('default_lang')
						   ->orderBy("products.id","desc"); 

		return Datatables::eloquent($products)
                        ->addColumn('thumbnail', function ($product) {
                            return '<div class="thumbnail-holder">
                                        <img src="'. asset('storage/app/'.$product->image->file_path) .'">
                                    </div>';
                        })
                        ->editColumn('translation.name', function ($product) {
                            if($product->translation->name == ''){
                                return $product->default_lang[0]->name;
                            }
                            return $product->translation->name;
                        })
                        ->editColumn('price', function ($product) {
                            return decimalPlace($product->price, currency());
                        })
                        ->editColumn('is_active', function ($product) {
                            return status($product->is_active);
                        })
						->addColumn('action', function ($product) {
								return '<form action="'.action('ProductController@destroy', $product['id']).'" class="text-center" method="post">'
								.'<a href="'.action('ProductController@edit', $product['id']).'" class="btn btn-warning btn-xs"><i class="far fa-edit"></i></a>&nbsp;'
								.csrf_field()
								.'<input name="_method" type="hidden" value="DELETE">'
								.'<button class="btn btn-danger btn-xs btn-remove" type="submit"><i class="fas fa-eraser"></i></button>'
								.'</form>';
						})
						->setRowId(function ($product) {
							return "row_".$product->id;
						})
						->rawColumns(['thumbnail', 'price', 'is_active', 'action'])
						->make(true);							    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.product.create');
        }else{
           return view('backend.product.modal.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
        $max_size = get_option('digital_file_max_upload_size',2) * 1024;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
			'description' => 'required',
			'product_type' => 'required',
			'price' => 'required|numeric',
			'special_price' => 'nullable|numeric',
			'manage_stock' => 'required',
			'qty' => 'required_if:manage_stock,1',
			'is_active' => 'required',
			'digital_file' => "required_if:product_type,digital_product|file|mimes:zip|max:$max_size",
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect()->route('products.create')
                	             ->withErrors($validator)
                	             ->withInput();
            }			
        }
	
        $digital_file = "";
        if($request->hasfile('digital_file') && $request->product_type == 'digital_product')
	    {
            $file = $request->file('digital_file');
            $digital_file = Storage::putFile('digital_file', $file);
	    }

        DB::beginTransaction();

        $product = new Product();
        $product->brand_id = $request->input('brand_id');
		$product->tax_class_id = $request->input('tax_class_id');
		$product->slug = $request->input('name');
		$product->product_type = $request->input('product_type');
		$product->price = $request->input('price');
		$product->special_price = $request->input('special_price');
		//$product->special_price_start = $request->input('special_price_start');
		//$product->special_price_end = $request->input('special_price_end');
		$product->sku = $request->input('sku');
		$product->manage_stock = $request->input('manage_stock');
		$product->qty = $request->input('qty');
		$product->in_stock = $request->input('in_stock');
		$product->viewed = 0;
        $product->is_active = $request->input('is_active');
		$product->featured_tag = $request->input('featured_tag');
		$product->digital_file = $digital_file;

        $product->save();

        //Store categories
        if(isset($request->categories)){
            $product->categories()->attach($request->categories);
        }

        //Store tags
        if(isset($request->tags)){
            $product->tags()->attach($request->tags);
        }

        //Store Product variations
        if($product->product_type == 'variable_product'){

            if(isset($request->product_option)){
                $i = 0;
                foreach($request->product_option as $product_option){
                    $variation = $product->product_options()->create(['name' => $product_option]);

                    //Store Product value
                    if(isset($request->product_option_value[$i])){
                        foreach(explode(',',$request->product_option_value[$i]) as $product_option_value){
                            $variation->items()->create(['name' => $product_option_value]);
                        }
                    }

                    $i++;
                } 
            } 
      

            //Store Variations Price
            $variations = array();

            foreach($product->product_options as $product_option){
                $variations[$product_option->id] = $product_option->items;
            }

            $i = 0;
            foreach(cartesian($variations) as $variation){
                $data = array();
                $data['option'] = json_encode($variation);
                $data['price'] = isset($request->variation_price[$i]) ? $request->variation_price[$i] : $request->price;
                $data['special_price'] = isset($request->variation_special_price[$i]) ? $request->variation_special_price[$i] : $request->special_price;
                $data['is_available'] = isset($request->is_available[$i]) ? $request->is_available[$i] : 0;
                $product->variation_prices()->create($data);

                $i++;
            }
        }


        //Store translations
        $translation = new ProductTranslation([
            'name' => $request->name, 
            'description' => $request->description,
            'short_description' => $request->short_description
        ]);
        $product->translation()->save($translation);


        DB::commit();

        if(! $request->ajax()){
           return redirect()->route('products.create')->with('success', _lang('Saved Sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'), 'data'=>$product, 'table' => '#products_table']);
        }
        
   }
	

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $product = Product::find($id);
        if(! $request->ajax()){
            return view('backend.product.edit',compact('product','id'));
        }else{
            return view('backend.product.modal.edit',compact('product','id'));
        }  
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $max_size = get_option('digital_file_max_upload_size',2) * 1024;

		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'product_type' => 'required',
            'price' => 'required|numeric',
            'special_price' => 'nullable|numeric',
            'manage_stock' => 'required',
            'qty' => 'required_if:manage_stock,1',
            'is_active' => 'required',
            'digital_file' => "nullable|file|mimes:zip|max:$max_size",
        ]);

		if ($validator->fails()) {
			if($request->ajax()){ 
				return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('products.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	

        if($request->hasfile('digital_file') && $request->product_type == 'digital_product')
        {
            $file = $request->file('digital_file');
            $digital_file = Storage::putFile('digital_file', $file);
        }
		
        DB::beginTransaction();

        $product = Product::find($id);
		$product->brand_id = $request->input('brand_id');
        $product->tax_class_id = $request->input('tax_class_id');
        //$product->slug = $request->input('name');
        $product->product_type = $request->input('product_type');
        $product->price = $request->input('price');
        $product->special_price = $request->input('special_price');
        //$product->special_price_start = $request->input('special_price_start');
        //$product->special_price_end = $request->input('special_price_end');
        $product->sku = $request->input('sku');
        $product->manage_stock = $request->input('manage_stock');
        $product->qty = $request->input('qty');
        $product->in_stock = $request->input('in_stock');
        $product->is_active = $request->input('is_active');
        $product->featured_tag = $request->input('featured_tag');

		if($request->hasfile('digital_file') && $product->product_type == 'digital_product'){
			$product->digital_file = $digital_file;
		}
	
        $product->save();

        //Store categories
        if(isset($request->categories)){
            $product->categories()->detach();
            $product->categories()->attach($request->categories);
        }

        //Store tags
        if(isset($request->tags)){
            $product->tags()->detach();
            $product->tags()->attach($request->tags);
        }


        //Store Product variations
        if($product->product_type == 'variable_product' && $request->update_variation == 1){
            
            //Remove Previous Data
            $product->product_options()->delete();
            $product->variation_prices()->delete();

            if(isset($request->product_option)){
                $i = 0;
                foreach($request->product_option as $product_option){
                    $variation = $product->product_options()->create(['name' => $product_option]);

                    //Store Variation Items
                    if(isset($request->product_option_value[$i])){
                        foreach(explode(',',$request->product_option_value[$i]) as $product_option_value){
                            $variation->items()->create(['name' => $product_option_value]);
                        }
                    }

                    $i++;
                } 
            } 
      

            //Store Variations Price
            $variations = array();

            foreach($product->product_options as $product_option){
                $variations[$product_option->id] = $product_option->items;
            }

            $i = 0;
            foreach(cartesian($variations) as $variation){
                $data = array();
                $data['option'] = json_encode($variation);
                $data['price'] = isset($request->variation_price[$i]) ? $request->variation_price[$i] : $request->price;
                $data['special_price'] = isset($request->variation_special_price[$i]) ? $request->variation_special_price[$i] : $request->special_price;
                $data['is_available'] = isset($request->is_available[$i]) ? $request->is_available[$i] : 0;
                $product->variation_prices()->create($data);

                $i++;
            }
        }

        //Update Translation
        $translation = ProductTranslation::firstOrNew(['product_id' => $product->id, 'locale' => get_language()]);
        $translation->product_id = $product->id;
        $translation->name = $request->name;
        $translation->description = $request->description;
        $translation->short_description = $request->short_description;
        $translation->save();


        Db::commit();
		
		if(! $request->ajax()){
           return redirect()->route('products.index')->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'), 'data'=>$product, 'table' => '#products_table']);
		}
	    
    }

    public function generate_variations(Request $request){
        $variations = array();

        $option_values = explode('&',$request->product_option_value[0]);

        $index = 0;
        foreach(explode('&',$request->product_option[0]) as $product_option){
            $option_value = explode('=',$option_values[$index]);
            $variations[$index] = explode('%2C',$option_value[1]);
            $index++;
        }

        echo json_encode(cartesian($variations));
    }

    /** Get variation price **/
    public function get_variation_price(Request $request, $product_id){
        $variationPrices = ProductVariationPrice::where('product_id',$product_id)->get();

        $price = "";
        $special_price = "";
        $is_available = true;
        
        foreach($variationPrices as $variation_price){
            $variation = array();

            foreach(json_decode($variation_price->option) as $option){
                array_push($variation, $option->id);
            }

            $result = array_diff($variation, $request->product_option);
            

            if(empty($result)){
                $price = show_price($variation_price->price);
                $special_price = $variation_price->special_price != '' ? show_price($variation_price->special_price) : '';
                $is_available = $variation_price->is_available == 1 ? true : false;
                break;
            }
        }

        if($price == "" && $special_price == ""){
            echo json_encode(
                array(
                    'result'        => false,
                    'price'         => $price,
                    'special_price' => $special_price,
                )
            );
        }else{
            echo json_encode(
                array(
                    'result'        => true,
                    'price'         => $price,
                    'special_price' => $special_price,
                    'is_available'  => $is_available,
                )
            );
        } 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        $product = Product::find($id);
        $product->files()->detach();
        $product->meta()->delete();
        $product->delete();

        DB::commit();

        return redirect()->route('products.index')->with('success',_lang('Deleted Sucessfully'));
    }
}