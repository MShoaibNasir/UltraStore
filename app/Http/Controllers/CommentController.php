<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductComment;
use Validator;
use DataTables;

class CommentController extends Controller
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
        return view('backend.discussions.comment.list');
    }
	
	public function get_table_data(){
		
		$productcomments = ProductComment::select('product_comments.*')
                                         ->with('user')
                                         ->with('product.translation')
                                         ->where('parent_id',null)
						                 ->orderBy("product_comments.id","desc");

		return Datatables::eloquent($productcomments)
                        ->addColumn('body', function ($productcomment) {
                            return strlen($productcomment->body) >= 70 ? substr($productcomment->body, 0, 70) . ' . . . .' : $productcomment->body;
                        })
                        ->addColumn('replies', function ($productcomment) {
                            return '<div class="text-center">' . $productcomment->replies->count() . '</div>';
                        })
						->addColumn('action', function ($productcomment) {
                                return '<form action="'.action('CommentController@destroy', $productcomment['id']).'" class="text-center" method="post">'
                                .'<a href="'.action('CommentController@show', $productcomment['id']).'" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></a>&nbsp;'
                                .csrf_field()
                                .'<input name="_method" type="hidden" value="DELETE">'
                                .'<button class="btn btn-danger btn-xs btn-remove" type="submit"><i class="fas fa-eraser"></i></button>'
                                .'</form>';
                        })

						->setRowId(function ($productcomment) {
							return "row_".$productcomment->id;
						})
						->rawColumns(['replies', 'action'])
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
        $productcomment = ProductComment::find($id);
        if(! $request->ajax()){
            return view('backend.discussions.comment.view',compact('productcomment','id'));
        }else{
            return view('backend.discussions.comment.modal.view',compact('productcomment','id'));
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
        $productcomment = ProductComment::find($id);
        $parent_id = $productcomment->parent_id;
        $productcomment->delete();

        if($parent_id == null){
            return redirect()->route('product_comments.index')->with('success',_lang('Deleted Successfully'));
        }

        return back()->with('success',_lang('Deleted Successfully'));
    }
}