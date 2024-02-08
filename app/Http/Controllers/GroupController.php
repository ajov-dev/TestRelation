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
		try {
			return $this->groupService->index();
		} catch (Exception $e) {
			return [
				'error' => $e->getMessage(),
			];
		}
	}

	public function store(Request $request)
	{
		try {
			// return $this->groupService->store($request->validate($rules, $messages));

			$this->groupService->storeGroups($request->input());

			return $this->groupService->index();

		} catch (Exception $e) {

			// Puedes personalizar el mensaje de error que se devuelve al cliente
			return response()->json([
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public function show($id): Group
	{
		return Group::with(['modules.themes.subThemes'])->find($id);
		//return $this->groupService->show($id);
	}

	public function update(Request $request, int $id): array
	{
		try {
		} catch (Exception $e) {
			return [
				'error' => $e->getMessage(),
			];
		}
	}

	public function destroy(int $id): array
	{
		try {
			return $this->groupService->destroy($id);
		} catch (Exception $e) {
			return [
				'error' => $e->getMessage(),
			];
		}
	}


}
