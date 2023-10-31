<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Entity\Tag\Tag;
use App\Entity\Tag\TagTranslation;
use Validator;
use DB;

class TagController extends Controller
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
        $tags = Tag::all()->sortByDesc("id");
        return view('backend.product.tag.list',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if( ! $request->ajax()){
           return view('backend.product.tag.create');
        }else{
           return view('backend.product.tag.modal.create');
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
            'name' => 'required|unique:tags_translation',
        ]);

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return redirect()->route('tags.create')
                	             ->withErrors($validator)
                	             ->withInput();
            }			
        }
	
        DB::beginTransaction();

        $tag = new Tag();
        $tag->slug = $request->input('name');

        $tag->save();

        //Save Translation
        $translation = new TagTranslation(['name' => $request->name]);
        $tag->translation()->save($translation);

        DB::commit();

        //Prefix Output
        $tag->name = $tag->translation->name;

        if(! $request->ajax()){
           return redirect()->route('tags.create')->with('success', _lang('Saved Sucessfully'));
        }else{
           return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$tag, 'table' => '#tags_table']);
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
        $tag = Tag::find($id);
        if(! $request->ajax()){
            return view('backend.product.tag.view',compact('tag','id'));
        }else{
            return view('backend.product.tag.modal.view',compact('tag','id'));
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
        $tag = Tag::find($id);
        if(! $request->ajax()){
            return view('backend.product.tag.edit',compact('tag','id'));
        }else{
            return view('backend.product.tag.modal.edit',compact('tag','id'));
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
                Rule::unique('tags_translation')->ignore($id, 'tag_id'),
            ],
		]);

		if ($validator->fails()) {
			if($request->ajax()){ 
				return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('tags.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}
	
        	
		DB::beginTransaction();

        $tag = Tag::find($id);
        if(get_language() == get_option('language')){
            $tag->slug = $request->input('name');
        }	
	
        $tag->save();

        //Update Translation
        $translation = TagTranslation::firstOrNew(['tag_id' => $tag->id, 'locale' => get_language()]);
        $translation->tag_id = $tag->id;
        $translation->name = $request->name;
        $translation->save();

        Db::commit();

        //Prefix Output
        $tag->name = $tag->translation->name;
		
		if(! $request->ajax()){
           return redirect()->route('tags.index')->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'),'data'=>$tag, 'table' => '#tags_table']);
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
        $tag = Tag::find($id);
        $tag->delete();
        return redirect()->route('tags.index')->with('success',_lang('Deleted Sucessfully'));
    }
}