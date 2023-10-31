<?php

namespace App\Http\Controllers;

use App\Media;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class MediaController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (!request()->ajax()) {
			return view('backend.media.list');
		} else {
			return view('backend.media.modal.list');
		}
	}

	public function get_table_data($type = '', $select_type = '') {

		$medias = Media::select('media.*')
			->orderBy("media.id", "desc");

		return Datatables::eloquent($medias, $type, $select_type)
			->addColumn('file', function ($media) {
				return '<div class="thumbnail-holder">'
				. '<img src="' . asset("storage/app/" . $media->file_path) . '">'
					. '</div>';
			})
			->editColumn('file_size', function ($media) {
				return round($media->file_size / 1024) . " KB";
			})
			->addColumn('action', function ($media) use ($type, $select_type) {
				if ($type == '') {
					return '<form action="' . action('MediaController@destroy', $media['id']) . '" class="text-center ajax-remove" method="post">'
					. '<a href="' . action('MediaController@show', $media['id']) . '" data-title="' . _lang('View Media') . '" class="btn btn-primary btn-xs ajax-modal"><i class="fas fa-eye"></i></a>&nbsp;'
					. csrf_field()
						. '<input name="_method" type="hidden" value="DELETE">'
						. '<button class="btn btn-danger btn-xs" type="submit"><i class="fas fa-eraser"></i></button>'
						. '</form>';
				} else {

					if ($select_type == 'multiple') {
						return '<div class="text-center"><button type="button" data-id="' . $media->id . '" data-path="' . $media->file_path . '"  class="btn btn-light select-multiple-media btn-xs">' . _lang('Select') . '</button></div>';
					}

					return '<div class="text-center"><button type="button" data-id="' . $media->id . '" data-path="' . $media->file_path . '" class="btn btn-light select-media btn-xs">' . _lang('Select') . '</button></div>';

				}
			})
			->setRowAttr([
				'data-id' => function ($media) {
					return 'row_' . $media->id;
				},
			])
			->rawColumns(['file', 'action'])
			->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		if ($request->ajax()) {
			return view('backend.media.modal.create');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$max_size = get_option('media_max_upload_size', 2) * 1024;
		$supported_file_types = get_option('media_file_type_supported', 'png,jpg,jpeg');

		$validator = Validator::make($request->all(), [
			'file' => "required|file|max:$max_size|mimes:$supported_file_types",
		],
			[
				'mimes' => 'File type is not supported',
			]);

		if ($validator->fails()) {
			if ($request->ajax()) {
				return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
			} else {
				return redirect()->route('media.create')
					->withErrors($validator)
					->withInput();
			}
		}

		$file = $request->file('file');
		$path = Storage::putFile('media', $file);

		$media = new Media();
		$media->filename = $file->getClientOriginalName();
		$media->file_path = $path;
		$media->file_type = $file->getClientMimeType();
		$media->file_size = $file->getSize();
		$media->file_extension = $file->guessClientExtension() ?? '';
		$media->user_id = Auth::id();

		$media->save();

		if (!$request->ajax()) {
			return redirect()->route('media.create')->with('success', _lang('Uploaded Sucessfully'));
		} else {
			return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Uploaded Sucessfully'), 'data' => $media, 'table' => '#media_table']);
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id) {
		$media = Media::find($id);
		if (!$request->ajax()) {
			return view('backend.media.view', compact('media', 'id'));
		} else {
			return view('backend.media.modal.view', compact('media', 'id'));
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$media = Media::find($id);
		Storage::delete($media->file_path);
		$media->delete();

		if (!request()->ajax()) {
			return redirect()->route('media.index')->with('success', _lang('Deleted Sucessfully'));
		} else {
			return response()->json(['result' => 'success', 'message' => _lang('Deleted Sucessfully'), 'id' => $id, 'table' => '#media_table']);
		}

	}
}