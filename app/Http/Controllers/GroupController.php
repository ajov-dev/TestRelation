<?php

namespace App\Http\Controllers;

use App\Models\GroupModule;
use App\Models\ModuleInstructor;
use App\Models\ModuleTheme;
use App\Services\GroupService;
use Illuminate\Http\Request;
use App\Models\Group;
use Exception;

class GroupController extends Controller
{
	private GroupService $groupService;

	public function __construct(GroupService $groupService)
	{
		$this->groupService = $groupService;
	}

	public function index()
	{
		return $this->groupService->index();
	}

	public function store(Request $request)
	{
		//return $request->input();
		try {
			$this->groupService->store($request->input());
			return $this->index();
		} catch (Exception $e) {
			return response()->json(['data' => ['message' => $e->getMessage()]], 500);
		}
	}
}
