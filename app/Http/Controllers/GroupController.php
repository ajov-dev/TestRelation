<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use Illuminate\Http\JsonResponse;
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
		try {
			$this->groupService->store($request->input());
			return $this->index();
		} catch (Exception $e) {
			return response()->json(['data' => ['message' => $e->getMessage()]], 500);
		}
	}

	public function destroy(Group $Group)
	{
		return new JsonResponse($this->groupService->destroy($Group));
	}
}
