<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductReviews;
use App\Entity\Product\Product;
use Validator;


class ReviewsController extends Controller
{ 
    private $theme;

    public function __construct()
    { 
        $this->theme = env('ACTIVE_THEME','default');        
        date_default_timezone_set(get_option('timezone','Asia/Dhaka'));       
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
            'comment' => 'required',
            'rating'  => 'required',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => false,'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)
                             ->withInput();
            }           
        }	

        if ( auth()->user()->reviewHas($request->product_id)) {
            if($request->ajax()){
                return response()->json([
                            'result' => false, 
                            'message' => _lang('Sorry, You have already submit a review for this item !'), 
                        ]);
            }else{
                return back()->with('error',_lang('Sorry, You have already submit a review for this item !'));
            }
        }
   
        $inputs = $request->all();
        $inputs['is_approved'] = 0;
        $inputs['user_id'] = auth()->user()->id;
    
        $review = ProductReviews::create($inputs);

		
		if($request->ajax()){
            $reviews = Product::find($request->product_id)->reviews;
			return response()->json([
								'result' => true, 
								'action' => 'store',
								'message' => _lang('Thank you for submitting your review. it will be published once approved by the authority.'), 
								'total_reviews' => $reviews->count()
							]);
		}else{
			return back()->with('success',_lang('Thank you for submitting your review. it will be published once approved by the authority.'));
		}
    }

}