<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModuleResource;
use App\Models\Module;
use App\Models\Group;
use App\Services\ModuleService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
	protected Module $Module;
	protected ModuleService $ModuleService;

	public function __construct(Module $Module, ModuleService $ModuleService)
	{
		$this->Module = $Module;
		$this->ModuleService = $ModuleService;
	}

	public function index()
	{
		return $this->ModuleService->index();
	}

	public function store(Request $request)
	{
		$units = $request->input('units');

		foreach ($units as $unit) {
			$unit['created_by'] = 'admin';
			$unit['updated_by'] = 'admin';
			$unit['group_id'] = $request->input('group_id');
			$this->ModuleService->updateOrCreateModules($unit);
		}

		$response = Module::with(['instructors', 'themes'])->get();
		return ModuleResource::collection($response);
		// return ModuleResource::collection
	}
}
