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
			// Manejo de excepciones: Reportar y renderizar
			report($e); // Esta función puede enviar la excepción a servicios de registro como Loggly o Sentry

			// Puedes personalizar el mensaje de error que se devuelve al cliente
			return response()->json([
				'error' => 'Ocurrió un error. Por favor, intenta nuevamente más tarde.',
			], 500);

			// O simplemente puedes volver a lanzar la excepción si deseas que sea manejada por el manejador de excepciones global de Laravel.
			// throw $e;
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
