<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Setting;
use Artisan;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class UtilityController extends Controller {
	/**
	 * Show the Settings Page.
	 *
	 * @return Response
	 */
	public function __construct() {
		header('Cache-Control: no-cache');
		header('Pragma: no-cache');
		date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
	}

	public function shipping_methods() {
		return view('backend.administration.shipping_methods');
	}

	public function settings(Request $request, $store = '') {
		if ($store == '') {
			return view('backend.administration.general_settings.settings');
		} else {
			foreach ($_POST as $key => $value) {
				if ($key == "_token") {
					continue;
				}

				$data = array();
				$data['value'] = is_array($value) ? json_encode($value) : $value;
				$data['updated_at'] = Carbon::now();
				if (Setting::where('name', $key)->exists()) {
					Setting::where('name', '=', $key)->update($data);
				} else {
					$data['name'] = $key;
					$data['created_at'] = Carbon::now();
					Setting::insert($data);
				}
				\Cache::put($key, $value);
			} //End Loop

			foreach ($_FILES as $key => $value) {
				$this->upload_file($key, $request);
			}

			\Cache::forget('currency_position');
			\Cache::forget('currency');
			\Cache::forget('date_format');
			\Cache::forget('time_format');
			\Cache::forget('language');

			if (!$request->ajax()) {
				return back()->with('success', _lang('Saved Sucessfully'));
			} else {
				return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Saved Sucessfully')]);
			}
		}
	}

	public function upload_logo(Request $request) {
		$this->validate($request, [
			'logo' => 'required|image|mimes:jpeg,png,jpg|max:8192',
		]);

		if ($request->hasFile('logo')) {
			$image = $request->file('logo');
			$name = 'logo.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/media');
			$image->move($destinationPath, $name);

			$data = array();
			$data['value'] = $name;
			$data['updated_at'] = Carbon::now();

			if (Setting::where('name', "logo")->exists()) {
				Setting::where('name', '=', "logo")->update($data);
			} else {
				$data['name'] = "logo";
				$data['created_at'] = Carbon::now();
				Setting::insert($data);
			}

			\Cache::put("logo", $name);

			if (!$request->ajax()) {
				return back()->with('success', _lang('Saved Sucessfully'));
			} else {
				return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Logo Upload successfully')]);
			}

		}
	}

	public function upload_file($file_name, Request $request) {
		if ($request->hasFile($file_name)) {
			$file = $request->file($file_name);
			$name = 'file_' . uniqid() . "." . $file->getClientOriginalExtension();
			$destinationPath = public_path('/uploads/media');
			$file->move($destinationPath, $name);

			$data = array();
			$data['value'] = $name;
			$data['updated_at'] = Carbon::now();

			if (Setting::where('name', $file_name)->exists()) {
				Setting::where('name', '=', $file_name)->update($data);
			} else {
				$data['name'] = $file_name;
				$data['created_at'] = Carbon::now();
				Setting::insert($data);
			}

			\Cache::put($file_name, $name);
		}
	}

	public function theme_option(Request $request, $page = 'general_settings', $store = '') {
		if ($store == '') {
			$theme = env('ACTIVE_THEME', 'default');
			return view("theme.$theme.theme_option.$page");
		} else {
			foreach ($_POST as $key => $value) {
				if ($key == "_token") {
					continue;
				}

				$data = array();
				$data['value'] = is_array($value) ? json_encode($value) : $value;
				$data['updated_at'] = Carbon::now();

				if (Setting::where('name', $key)->exists()) {
					$setting = Setting::where('name', $key)->first();
					$setting->value = $data['value'];
					$setting->save();

					//Update Translation
					$translation = \App\SettingTranslation::firstOrNew(['setting_id' => $setting->id,
						'locale' => get_language()]);
					$translation->setting_id = $setting->id;
					$translation->value = $setting->value;
					$translation->save();

				} else {
					$setting = new Setting();
					$setting->name = $key;
					$setting->value = $data['value'];
					$setting->save();

					//Save Translation
					$translation = new \App\SettingTranslation(['value' => $data['value']]);
					$setting->translation()->save($translation);
				}

				\Cache::put($key, $value);
				\Cache::put($key . "-" . get_language(), $value);

			} //End $_POST Loop

			//Upload File
			foreach ($_FILES as $key => $value) {
				$this->upload_file($key, $request);
			}

			if (!$request->ajax()) {
				return back()->with('success', _lang('Saved sucessfully'));
			} else {
				return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Saved sucessfully')]);
			}
		}
	}

	public function select_language($language) {
		session(['language' => $language]);
		return back();
	}

	/**
	 * Display a list of database backup
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function database_backup_list() {
		$databasebackups = \App\DatabaseBackup::all()->sortByDesc("id");
		return view('backend.administration.database_backup.list', compact('databasebackups'));
	}

	public function create_database_backup() {
		@ini_set('max_execution_time', 0);
		@set_time_limit(0);

		$return = "";
		$database = 'Tables_in_' . DB::getDatabaseName();
		$tables = array();
		$result = DB::select("SHOW TABLES");

		foreach ($result as $table) {
			$tables[] = $table->$database;
		}

		//loop through the tables
		foreach ($tables as $table) {
			$return .= "DROP TABLE IF EXISTS $table;";

			$result2 = DB::select("SHOW CREATE TABLE $table");
			$row2 = $result2[0]->{'Create Table'};

			$return .= "\n\n" . $row2 . ";\n\n";

			$result = DB::select("SELECT * FROM $table");

			foreach ($result as $row) {
				$return .= "INSERT INTO $table VALUES(";
				foreach ($row as $key => $val) {
					$return .= "'" . addslashes($val) . "',";
				}
				$return = substr_replace($return, "", -1);
				$return .= ");\n";
			}

			$return .= "\n\n\n";
		}

		//save file
		$file_name = 'DB-BACKUP-' . time() . '.sql';
		$file = 'public/backup/DB-BACKUP-' . $file_name;
		$handle = fopen($file, 'w+');
		fwrite($handle, $return);
		fclose($handle);

		$databasebackup = new \App\DatabaseBackup();
		$databasebackup->file = $file_name;
		$databasebackup->user_id = Auth::id();

		$databasebackup->save();

		return back()->with('success', _lang('Backup Created Sucessfully'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function download_database_backup($id) {
		$databasebackup = \App\DatabaseBackup::find($id);
		$file = 'public/backup/DB-BACKUP-' . $databasebackup->file;
		return response()->download($file);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy_database_backup($id) {
		$databasebackup = \App\DatabaseBackup::find($id);
		$file = 'public/backup/DB-BACKUP-' . $databasebackup->file;
		$databasebackup->delete();
		unlink($file);

		return redirect()->route('database_backups.list')->with('success', _lang('Deleted Sucessfully'));
	}

	public function remove_cache(Request $request) {
		$this->validate($request, [
			'cache' => 'required',
		]);

		if (isset($_POST['cache']['view_cache'])) {
			Artisan::call('view:clear');
		}

		if (isset($_POST['cache']['application_cache'])) {
			Artisan::call('cache:clear');
		}

		Artisan::call('config:clear');

		return back()->with('success', _lang('Cache Removed Sucessfully'));
	}

}