<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;

class ModuleController extends Controller
{
    //construcor

	public function __construct()
	{

	}

	// public function index()
	// {
	// 	return [
	// 		'modules' => Module::with(['themes.subThemes'])->get()
	// 	];
	// }

	// store
	public function store(Request $request)
	{
		$module = Module::create($request->all());
		return response()->json($module, 201);
	}
}
