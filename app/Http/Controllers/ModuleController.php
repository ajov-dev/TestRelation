<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Group;
use App\Services\ModuleService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private ModuleService $ModuleService;
	private Module $module;

    public function __construct(ModuleService $ModuleService, Module $module)
    {
        $this->ModuleService = $ModuleService;
		$this->module = $module;
    }
	public function store(Request $request)
	{
		$units = $request->input('units');


		foreach ($units as $unit) {
			$unit['created_by'] = 'admin';
			$unit['updated_by'] = 'admin';
			$unit['group_id'] = $request->input('group_id');
			$this->ModuleService->updateOrCreateModule($unit);
		}

		return Group::with(['modules' => function ($q) {
			$q->with(['instructor', 'themes.sub_theme']);
		}])->find($request->input('group_id'));
	}
}
