<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductComment;
use App\Entity\Product\Product;
use Validator;


class CommentController extends Controller
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
            'body'=>'required',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => false,'message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)
                             ->withInput();
            }           
        }
   
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
    
        $comment = ProductComment::create($input);

		
		if($request->ajax()){
            $comments = Product::find($request->product_id)->comments;
            $commentView = view("theme.$this->theme.components.comments",compact('comments'))->render();
			return response()->json(['result' => true, 'action' => 'store','message' => _lang('Your comment posted sucessfully'), 'comments' => $commentView, 'total_comments' => $comments->count()]);
		}else{
			return back()->with('success',_lang('Your comment posted sucessfully'));
		}
    }

}