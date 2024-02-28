<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Models\Module;
use App\Services\ModuleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

	public function store(StoreModuleRequest $req)
	{

		$req['whereNotIn'] = collect($req->units)->pluck('id');

		return $this->ModuleService->destroyModules($req);
	}
}
