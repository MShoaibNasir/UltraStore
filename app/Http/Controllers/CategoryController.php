<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Entity\Category\Category;
use App\Entity\Category\CategoryTranslation;
use Validator;
use DB;

class CategoryController extends Controller
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
        $categories = Category::all()->sortByDesc("category.translation.name");
        return view('backend.product.category.list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.product.category.create');
        }else{
           return view('backend.product.category.modal.create');
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
            'name' => 'required|unique:category_translation',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect()->route('category.create')
                	             ->withErrors($validator)
                	             ->withInput();
            }			
        }
	
        
        DB::beginTransaction();

        $category = new Category();
        $category->slug = $request->input('name');
		$category->parent_id = $request->input('parent_id');

        $category->save();

        //Save Translation
        $translation = new CategoryTranslation(['name' => $request->name, 'description' => $request->description]);
        $category->translation()->save($translation);

        DB::commit();

        if(! $request->ajax()){
           return redirect()->route('category.index')->with('success', _lang('Saved Sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$category, 'table' => '#category_table']);
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
        $category = Category::find($id);
        if(! $request->ajax()){
            return view('backend.product.category.view',compact('category','id'));
        }else{
            return view('backend.product.category.modal.view',compact('category','id'));
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
        $category = Category::find($id);
        if(! $request->ajax()){
            return view('backend.product.category.edit',compact('category','id'));
        }else{
            return view('backend.product.category.modal.edit',compact('category','id'));
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
            'name' => [
                'required',
                Rule::unique('category_translation')->ignore($id, 'category_id'),
            ],
        ]);

		if ($validator->fails()) {
			if($request->ajax()){ 
				return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('category.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        
        DB::beginTransaction();	
		
        $category = Category::find($id);
        if(get_language() == get_option('language')){
    		$category->slug = $request->input('name');
        }
		$category->parent_id = $request->input('parent_id');
	
        $category->save();

        //Update Translation
        $translation = CategoryTranslation::firstOrNew(['category_id' => $category->id, 'locale' => get_language()]);
        $translation->category_id = $category->id;
        $translation->name = $request->name;
        $translation->description = $request->description;
        $translation->save();

        Db::commit();
		
		if(! $request->ajax()){
           return redirect()->route('category.index')->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'),'data'=>$category, 'table' => '#category_table']);
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

        $category = Category::find($id);
        $category->files()->detach();
        $category->delete();

        DB::commit();
        
        return redirect()->route('category.index')->with('success',_lang('Deleted Sucessfully'));
    }
}