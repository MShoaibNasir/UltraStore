<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductReviews;
use Validator;
use DataTables;

class ReviewsController extends Controller
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
        return view('backend.discussions.reviews.list');
    }
	
	public function get_table_data(){
		
		$productreviews = ProductReviews::select('product_reviews.*')
                                        ->with('user')
                                        ->with('product.translation')
						                ->orderBy("product_reviews.id","desc");

		return Datatables::eloquent($productreviews)
                        ->editColumn('id', function ($productreviews) {
                            return '<input type="checkbox" name="ids[]" value="'. $productreviews->id .'">';
                        })
                        ->editColumn('rating', function ($productreviews) {
                            return '<div class="text-center">'. $productreviews->rating .'</div>';
                        })
                        ->editColumn('is_approved', function ($productreviews) {
                            return $productreviews->is_approved == 1 ? '<div class="text-center"><span class="badge badge-success">'. _lang('Approved') .'</span></div>' : '<div class="text-center"><span class="badge badge-danger">'. _lang('Pending') .'</span></div>';
                        })
						->addColumn('action', function ($productreview) {
							return '<form action="'.action('ReviewsController@destroy', $productreview['id']).'" class="text-center" method="post">'
							.'<a href="'.action('ReviewsController@show', $productreview['id']).'" data-title="'. _lang('View Product Review') .'" class="btn btn-primary btn-xs ajax-modal"><i class="fas fa-eye"></i></a>&nbsp;'
							.'<a href="'.action('ReviewsController@edit', $productreview['id']).'" data-title="'. _lang('Update Product Review') .'" class="btn btn-warning btn-xs ajax-modal"><i class="far fa-edit"></i></a>&nbsp;'
							.csrf_field()
							.'<input name="_method" type="hidden" value="DELETE">'
							.'<button class="btn btn-danger btn-xs btn-remove" type="submit"><i class="fas fa-eraser"></i></button>'
							.'</form>';
						})
						->setRowId(function ($productreview) {
							return "row_".$productreview->id;
						})
						->rawColumns(['id', 'rating', 'is_approved','action'])
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
        $productreviews = ProductReviews::find($id);
        if(! $request->ajax()){
            return view('backend.discussions.reviews.view',compact('productreviews','id'));
        }else{
            return view('backend.discussions.reviews.modal.view',compact('productreviews','id'));
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
        $productreviews = ProductReviews::find($id);
        if(! $request->ajax()){
            return view('backend.discussions.reviews.edit',compact('productreviews','id'));
        }else{
            return view('backend.discussions.reviews.modal.edit',compact('productreviews','id'));
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
			'rating'      => 'required',
			'is_approved' => 'required',
		]);

		if ($validator->fails()) {
			if($request->ajax()){ 
				return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('product_reviews.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		
        $productreviews = ProductReviews::find($id);
		$productreviews->rating = $request->input('rating');
		$productreviews->comment = $request->input('comment');
		$productreviews->is_approved = $request->input('is_approved');
	
        $productreviews->save();
		
		if(! $request->ajax()){
           return redirect()->route('product_reviews.index')->with('success', _lang('Updated Successfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Successfully'), 'data' => $productreviews, 'table' => '#product_reviews_table']);
		}
	    
    }

    public function bulk_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bulk_action'      => 'required',
            'ids'              => 'required',
        ],[
            'ids.required' => _lang('You must select at least one row !')
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)
                             ->withInput();
            }           
        }

        if($request->bulk_action == 'approved'){
            ProductReviews::whereIn('id', $request->ids)
                          ->update([
                             'is_approved' => 1,
                          ]);
            return back()->with('success',_lang('Status Marked as Approved'));     

        }else if($request->bulk_action == 'pending'){
            ProductReviews::whereIn('id', $request->ids)
                          ->update([
                             'is_approved' => 0,
                          ]);
            return back()->with('success',_lang('Status Marked as Pending')); 
                           
        }else if($request->bulk_action == 'delete'){
            ProductReviews::whereIn('id', $request->ids)->delete();
            return back()->with('success',_lang('Deleted Successfully'));  
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
        $productreviews = ProductReviews::find($id);
        $productreviews->delete();
        return redirect()->route('product_reviews.index')->with('success',_lang('Deleted Successfully'));
    }
}