<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Coupon\Coupon;
use Validator;
use DB;

class CouponController extends Controller
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
        $coupons = Coupon::all()->sortByDesc("id");
        return view('backend.coupon.list',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.coupon.create');
        }else{
           return view('backend.coupon.modal.create');
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
        $validator = Validator::make($request->all(), [
            'code' => 'required',
			'value' => 'nullable|numeric',
			'is_percent' => 'required',
			'minimum_spend' => 'nullable|numeric',
			'maximum_spend' => $request->has('minimum_spend') ? 'nullable|numeric' : 'required|numeric',
			'usage_limit_per_coupon' => 'nullable|integer',
			'usage_limit_per_customer' => 'nullable|integer',
			'is_active' => 'required',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect()->route('coupons.create')
                	             ->withErrors($validator)
                	             ->withInput();
            }			
        }

        if(isset($request->products) && isset($request->exclude_products)){
            return redirect()->route('coupons.create')
                             ->with('error',_lang('Exclude products only allow when products filed is empty !'))
                             ->withInput();
        }

        if(isset($request->categories) && isset($request->exclude_categories)){
            return redirect()->route('coupons.create')
                             ->with('error',_lang('Exclude Categories only allow when categories filed is empty !'))
                             ->withInput();
        }
	
        
        DB::beginTransaction();

        $coupon = new Coupon();
        $coupon->code = $request->input('code');
		$coupon->value = $request->input('value');
		$coupon->is_percent = $request->input('is_percent');
		$coupon->free_shipping = 0;
		$coupon->minimum_spend = $request->input('minimum_spend');
		$coupon->maximum_spend = $request->input('maximum_spend');
		$coupon->usage_limit_per_coupon = $request->input('usage_limit_per_coupon');
		$coupon->usage_limit_per_customer = $request->input('usage_limit_per_customer');
		$coupon->is_active = $request->input('is_active');
		$coupon->start_date = $request->input('start_date');
		$coupon->end_date = $request->input('end_date');

        $coupon->save();

        //Store Products
        if(isset($request->products)){
            $coupon->products()->attach($request->products);
        }

        //Store Exclude Products
        if(isset($request->exclude_products)){
            $pivotData = array_fill(0, count($request->exclude_products), ['exclude' => true]);
            $coupon->excludeProducts()->sync(array_combine($request->exclude_products, $pivotData));
        }

        //Store Category
        if(isset($request->categories)){
            $coupon->categories()->attach($request->categories);
        }

        //Store Exclude Category
        if(isset($request->exclude_categories)){
            $pivotData = array_fill(0, count($request->exclude_categories), ['exclude' => true]);
            $coupon->excludeCategories()->sync(array_combine($request->exclude_categories, $pivotData));
        }

        //Store Translation
        $coupon->translation->fill($request->all())->save();

        DB::commit();

        if(! $request->ajax()){
           return redirect()->route('coupons.create')->with('success', _lang('Saved Sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$coupon, 'table' => '#coupons_table']);
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
        $coupon = Coupon::find($id);
        if(! $request->ajax()){
            return view('backend.coupon.edit',compact('coupon','id'));
        }else{
            return view('backend.coupon.modal.edit',compact('coupon','id'));
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
		$validator = Validator::make($request->all(), [
			'code' => 'required',
			'value' => 'nullable|numeric',
			'is_percent' => 'required',
			'minimum_spend' => 'nullable|numeric',
			'maximum_spend' => $request->has('minimum_spend') ? 'nullable|numeric' : 'required|numeric',
			'usage_limit_per_coupon' => 'nullable|integer',
			'usage_limit_per_customer' => 'nullable|integer',
			'is_active' => 'required',
		]);

		if ($validator->fails()) {
			if($request->ajax()){ 
				return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('coupons.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}

        if(isset($request->products) && isset($request->exclude_products)){
            return redirect()->route('coupons.edit', $id)
                             ->with('error',_lang('Exclude products only allow when products filed is empty !'))
                             ->withInput();
        }

        if(isset($request->categories) && isset($request->exclude_categories)){
            return redirect()->route('coupons.edit', $id)
                             ->with('error',_lang('Exclude Categories only allow when categories filed is empty !'))
                             ->withInput();
        }
    
	
        	
		DB::beginTransaction();

        $coupon = Coupon::find($id);
		$coupon->code = $request->input('code');
		$coupon->value = $request->input('value');
		$coupon->is_percent = $request->input('is_percent');
		$coupon->free_shipping = 0;
		$coupon->minimum_spend = $request->input('minimum_spend');
		$coupon->maximum_spend = $request->input('maximum_spend');
		$coupon->usage_limit_per_coupon = $request->input('usage_limit_per_coupon');
		$coupon->usage_limit_per_customer = $request->input('usage_limit_per_customer');
		$coupon->is_active = $request->input('is_active');
		$coupon->start_date = $request->input('start_date');
		$coupon->end_date = $request->input('end_date');
	
        $coupon->save();

        //Store Products
        if(isset($request->products)){
            $coupon->products()->sync($request->products);
        }else{
            $coupon->products()->detach();
        }

        //Store Exclude Products
        if(isset($request->exclude_products)){
            $pivotData = array_fill(0, count($request->exclude_products), ['exclude' => true]);
            $coupon->excludeProducts()->sync(array_combine($request->exclude_products, $pivotData));
        }else{
            $coupon->excludeProducts()->detach();
        }

        //Store Category
        if(isset($request->categories)){
            $coupon->categories()->sync($request->categories);
        }else{
            $coupon->categories()->detach();
        }

        //Store Exclude Category
        if(isset($request->exclude_categories)){
            $pivotData = array_fill(0, count($request->exclude_categories), ['exclude' => true]);
            $coupon->excludeCategories()->sync(array_combine($request->exclude_categories, $pivotData));
        }else{
            $coupon->excludeCategories()->detach();
        }

        //Update Translation
        $coupon->translation->fill($request->all())->save();

        DB::commit();
		
		if(! $request->ajax()){
           return redirect()->route('coupons.index')->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'),'data'=>$coupon, 'table' => '#coupons_table']);
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
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success',_lang('Deleted Sucessfully'));
    }
}