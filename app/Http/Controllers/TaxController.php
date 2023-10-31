<?php

namespace App\Http\Controllers;

use App\Entity\Tax\Tax;
use App\Entity\Tax\TaxRate;
use App\Entity\Tax\TaxRateTranslation;
use App\Entity\Tax\TaxTranslation;
use DB;
use Illuminate\Http\Request;
use Validator;

class TaxController extends Controller {

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
		$taxs = Tax::all()->sortByDesc("id");
		return view('backend.tax.list', compact('taxs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		if (!$request->ajax()) {
			return view('backend.tax.create');
		} else {
			return view('backend.tax.modal.create');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'tax_class' => 'required',
			'based_on' => 'required',
		]);

		if ($validator->fails()) {
			if ($request->ajax()) {
				return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
			} else {
				return redirect()->route('taxes.create')
					->withErrors($validator)
					->withInput();
			}
		}

		DB::beginTransaction();

		$tax = new Tax();
		$tax->based_on = $request->input('based_on');

		$tax->save();

		//Save Translation
		$translation = new TaxTranslation(['name' => $request->tax_class]);
		$tax->translation()->save($translation);

		//Store Tax Rate
		$index = 0;
		foreach ($request->tax_name as $tax_name) {
			$tax_rate = new TaxRate();
			$tax_rate->tax_class_id = $tax->id;
			$tax_rate->country = $request->country[$index];
			$tax_rate->state = $request->state[$index];
			$tax_rate->rate = $request->rate[$index];

			$tax_rate->save();

			//Store Translation
			$tax_rate_translation = new TaxRateTranslation();
			$tax_rate_translation->tax_rate_id = $tax_rate->id;
			$tax_rate_translation->name = $tax_name;

			$tax_rate_translation->save();

			$index++;
		}

		DB::commit();

		if (!$request->ajax()) {
			return redirect()->route('taxes.create')->with('success', _lang('Saved Sucessfully'));
		} else {
			return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Saved Sucessfully'), 'data' => $tax, 'table' => '#tax_classes_table']);
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id) {
		$tax = Tax::find($id);
		if (!$request->ajax()) {
			return view('backend.tax.view', compact('tax', 'id'));
		} else {
			return view('backend.tax.modal.view', compact('tax', 'id'));
		}

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id) {
		$tax = Tax::find($id);
		if (!$request->ajax()) {
			return view('backend.tax.edit', compact('tax', 'id'));
		} else {
			return view('backend.tax.modal.edit', compact('tax', 'id'));
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$validator = Validator::make($request->all(), [
			'tax_class' => 'required',
			'based_on' => 'required',
		]);

		if ($validator->fails()) {
			if ($request->ajax()) {
				return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
			} else {
				return redirect()->route('taxes.edit', $id)
					->withErrors($validator)
					->withInput();
			}
		}

		DB::beginTransaction();

		$tax = Tax::find($id);
		$tax->based_on = $request->input('based_on');

		$tax->save();

		//Save Translation
		$translation = TaxTranslation::firstOrNew(['tax_class_id' => $tax->id, 'locale' => get_language()]);
		$translation->tax_class_id = $tax->id;
		$translation->name = $request->tax_class;
		$translation->save();

		//Store Tax Rate
		$existing_rates = $tax->tax_rates;
		if (isset($request->tax_rate_id)) {
			//Remove Tax Rate
			foreach ($existing_rates as $existing_rate) {
				if (!in_array($existing_rate->id, $request->tax_rate_id)) {
					$tax_rate = TaxRate::find($existing_rate->id);
					$tax_rate->delete();
				}
			}

			//Store New Tax Rate
			$index = 0;
			foreach ($request->tax_rate_id as $tr) {
				if (!$existing_rates->contains('id', $tr)) {
					//Added New TaxRate
					$tax_rate = new TaxRate();
					$tax_rate->tax_class_id = $tax->id;
					$tax_rate->country = $request->country[$index];
					$tax_rate->state = $request->state[$index];
					$tax_rate->rate = $request->rate[$index];

					$tax_rate->save();

					//Store Translation
					$tax_rate_translation = new TaxRateTranslation();
					$tax_rate_translation->tax_rate_id = $tax_rate->id;
					$tax_rate_translation->name = $request->tax_name[$index];

					$tax_rate_translation->save();
				} else {
					//Update Existing TaxRate
					$tax_rate = TaxRate::find($tr);
					$tax_rate->tax_class_id = $tax->id;
					$tax_rate->country = $request->country[$index];
					$tax_rate->state = $request->state[$index];
					$tax_rate->rate = $request->rate[$index];

					$tax_rate->save();

					//Store Translation
					//$tax_rate_translation = new TaxRateTranslation();
					$tax_rate_translation = TaxRateTranslation::firstOrNew(['tax_rate_id' => $tax_rate->id, 'locale' => get_language()]);
					$tax_rate_translation->tax_rate_id = $tax_rate->id;
					$tax_rate_translation->name = $request->tax_name[$index];

					$tax_rate_translation->save();

				}

				$index++;
			}
		}

		/*$index = 0;
			        foreach($request->tax_name as $tax_name){
			            $tax_rate = new TaxRate();
			            $tax_rate->tax_class_id = $tax->id;
			            $tax_rate->country = $request->country[$index];
			            $tax_rate->state = $request->state[$index];
			            $tax_rate->rate = $request->rate[$index];

			            $tax_rate->save();

			            //Store Translation
			            $tax_rate_translation = new TaxRateTranslation();
			            $tax_rate_translation->tax_rate_id  = $tax_rate->id;
			            $tax_rate_translation->name = $tax_name;

			            $tax_rate_translation->save();

			            $index++;
		*/

		DB::commit();

		if (!$request->ajax()) {
			return redirect()->route('taxes.index')->with('success', _lang('Updated Sucessfully'));
		} else {
			return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Updated Sucessfully'), 'data' => $tax, 'table' => '#tax_classes_table']);
		}

	}

	public function get_states($country_id) {
		if ($country_id != "") {
			$states = get_states($country_id);
			echo json_encode($states);
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$tax = Tax::find($id);
		$tax->delete();
		return redirect()->route('taxes.index')->with('success', _lang('Deleted Sucessfully'));
	}
}