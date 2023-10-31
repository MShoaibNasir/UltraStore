<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Transaction;
use Validator;
use DataTables;
use DB;

class OrderController extends Controller
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
        return view('backend.order.list');
    }
	
	public function get_table_data(){
		
		$orders = Order::select('orders.*')
					   ->orderBy("orders.id","desc");

		return Datatables::eloquent($orders)
						->editColumn('status', function ($order) {
							return $order->getStatus();
						})
                        ->editColumn('total', function ($order) {
                            $amount = convert_currency_2(1, $order->currency_rate, $order->total);
                            return decimalPlace($amount, $order->currency);
                        })
                        ->addColumn('payment', function ($order) {
                            return $order->getPaymentStatus();
                        })
						->addColumn('action', function ($order) {
								return '<div class="text-center">
											<div class="dropdown">'
											.'<button class="btn btn-light btn-xs dropdown-toggle" type="button" data-toggle="dropdown">'._lang('Action')
											.'&nbsp;<i class="fas fa-angle-down"></i></button>'
											.'<div class="dropdown-menu">'
												.'<a class="dropdown-item" href="'. action('OrderController@show', $order->id) .'" data-title="'._lang('View Invoice') .'" data-fullscreen="true"><i class="fas fa-eye"></i> '._lang('View') .'</a>'
													.'<form action="'. action('OrderController@destroy', $order['id']) .'" method="post">'
														.csrf_field()
														.'<input name="_method" type="hidden" value="DELETE">'
														.'<button class="button-link btn-remove" type="submit"><i class="fas fa-trash"></i> '._lang('Delete') .'</button>'
													.'</form>'	
												.'</div>'
											.'</div>'
										.'</div>';
						})
						->setRowId(function ($order) {
							return "row_".$order->id;
						})
						->rawColumns(['action','status','payment','total'])
						->make(true);							    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $order = Order::find($id);
        if(! $request->ajax()){
            return view('backend.order.view',compact('order','id'));
        }else{
            return view('backend.order.modal.view',compact('order','id'));
        } 
        
    }

    /**
     * Update Order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'transaction_id' => 'required_if:payment_status,completed',
            'payment_method' => 'required_if:payment_status,completed',
        ],[
            'transaction_id.required_if' => _lang('Transaction ID is required !'),
            'payment_method.required_if' => _lang('Payment Method is required !'),
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)
                             ->withInput();
            }           
        }

        DB::beginTransaction();

        $order = Order::find($id);
        $previous_status = $order->status;

        $order->status = $request->status;
        $order->payment_method = $request->payment_method;
        $order->save();

        //Update Transaction
        if($request->payment_status == 'completed' && $order->getPaymentStatus(false) == 0){
            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->transaction_id = $request->transaction_id;
            $transaction->payment_method = $request->payment_method;
            $transaction->amount = convert_currency_2(1, $order->currency_rate, $order->total);
            $transaction->save();
        }

        if($request->status == 'canceled' && $previous_status != 'canceled'){
            foreach($order->products as $orderItem){
                $orderItem->product->increment('qty', $orderItem->qty);

                if ($orderItem->product->fresh()->qty > 0) {
                    $orderItem->product->revertOutOfStock();
                }
            }
        }else if($request->status != 'canceled' && $previous_status == 'canceled'){
            foreach($order->products as $orderItem){
                $orderItem->product->decrement('qty', $orderItem->qty);

                if ($orderItem->product->fresh()->qty === 0) {
                    $orderItem->product->outOfStock();
                }
            }
        }

        //Trigger Order Status Changed Event
        event(new \App\Events\OrderUpdated($order));


        DB::commit();

        return back()->with('success',_lang('Order Updated Sucessfully'));
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if($order->status != 'canceled' && $order->status != 'pending_payment'){
            foreach($order->products as $orderItem){
                $orderItem->product->increment('qty', $orderItem->qty);

                if ($orderItem->product->fresh()->qty > 0) {
                    $orderItem->product->revertOutOfStock();
                }
            }
        }

        $order->delete();
        return redirect()->route('orders.index')->with('success',_lang('Deleted Successfully'));
    }
}