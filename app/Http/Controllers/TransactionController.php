<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use DataTables;

class TransactionController extends Controller
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
        return view('backend.transaction.list');
    }
    
    public function get_table_data(){
        
        $transactions = Transaction::select('transactions.*')
                                    ->with('order')
                                    ->orderBy("transactions.id","desc");

        return Datatables::eloquent($transactions)
                        ->addColumn('currency', function ($transaction) {
                            return $transaction->order->currency;
                        })
                        ->editColumn('amount', function ($transaction) {
                            return decimalPlace($transaction->amount, $transaction->order->currency);
                        })
                        ->setRowId(function ($transaction) {
                            return "row_".$transaction->id;
                        })
                        ->rawColumns(['amount'])
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
        $transaction = Transaction::find($id);
        if(! $request->ajax()){
            return view('backend.transaction.view',compact('transaction','id'));
        }else{
            return view('backend.transaction.modal.view',compact('transaction','id'));
        } 
        
    }

}
