<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use Validator;

class CurrencyController extends Controller
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
        $currencys = Currency::all()->sortByDesc("id");
        return view('backend.currency.list',compact('currencys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.currency.create');
        }else{
           return view('backend.currency.modal.create');
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
            'name' => 'required',
			'base_currency' => '',
			'exchange_rate' => 'required|numeric',
			'status' => 'required',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect()->route('currency.create')
                	             ->withErrors($validator)
                	             ->withInput();
            }			
        }

        if($request->input('base_currency') == '1'){
            $currency = Currency::where('base_currency','1')->first();
            if($currency){
                $currency->base_currency = 0;
                $currency->save();
            }
        }
	     

        $currency = new Currency();
        $currency->name = $request->input('name');
		$currency->base_currency = $request->input('base_currency');
		$currency->exchange_rate = $request->input('exchange_rate');
		$currency->status = $request->input('status');

        $currency->save();

        \Cache::forget('currency');

        //Prefix output
        $currency->base_currency = $currency->base_currency == 1 ? _lang('Yes') : _lang('No');
        $currency->status = $currency->status == 1 ? _lang('Active') : _lang('InActive');

        if(! $request->ajax()){
           return redirect()->route('currency.create')->with('success', _lang('Saved Sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$currency, 'table' => '#currency_table']);
        }
        
   }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $currency = Currency::find($id);
        if(! $request->ajax()){
            return view('backend.currency.view',compact('currency','id'));
        }else{
            return view('backend.currency.modal.view',compact('currency','id'));
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
        $currency = Currency::find($id);
        if(! $request->ajax()){
            return view('backend.currency.edit',compact('currency','id'));
        }else{
            return view('backend.currency.modal.edit',compact('currency','id'));
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
			'name' => 'required',
			'base_currency' => '',
			'exchange_rate' => 'required|numeric',
			'status' => 'required',
		]);

		if ($validator->fails()) {
			if($request->ajax()){ 
				return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('currency.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}

        if($request->input('base_currency') == '1'){
            $base_currency = Currency::where('base_currency','1')->first();
            if($base_currency){
                $base_currency->base_currency = 0;
                $base_currency->save();
            }
        }   
	 	
		
        $currency = Currency::find($id);
		$currency->name = $request->input('name');
		$currency->base_currency = $request->input('base_currency');
		$currency->exchange_rate = $request->input('exchange_rate');
		$currency->status = $request->input('status');
	
        $currency->save();

        \Cache::forget('currency');

        //Prefix output
        $currency->base_currency = $currency->base_currency == 1 ? _lang('Yes') : _lang('No');
        $currency->status = $currency->status == 1 ? _lang('Active') : _lang('InActive');
		
		if(! $request->ajax()){
           return redirect()->route('currency.index')->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'),'data'=>$currency, 'table' => '#currency_table']);
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
        $currency = Currency::find($id);
        $currency->delete();
        return redirect()->route('currency.index')->with('success',_lang('Deleted Sucessfully'));
    }
}