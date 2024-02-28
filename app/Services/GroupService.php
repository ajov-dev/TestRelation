<?php

namespace App\Services;

use App\Http\Resources\GroupResource;
use App\Models\AcademicActivity;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AcademicActivityResource;

/**
 * Class GroupService.
 */
class GroupService
{
	public const create_by = 'admin';
	public const update_by = 'admin';
	protected Group $group;
	protected ModuleService $ModuleService;

	public function __construct(Group $group, ModuleService $ModuleService)
	{
		$this->group = $group;
		$this->ModuleService = $ModuleService;
	}
	public function index()
	{
		$response = $this->group->with([
			'modules' => function ($q){
				$q->with(['themes', 'instructors']);
			}
		])->get();
		return GroupResource::collection($response);
		// return $response;
	}
	public function store(array $req): void
	{
		DB::transaction(function () use ($req) {
			$group = Group::find($req['id']);

			if (isset($req['units'])){

				$req['whereNotIn'] = collect($req['themes'])->pluck('id');

				$this->ModuleService->destroyModules($req);

				foreach ($req['units'] as $ModuleData) {

					$ModuleData['group_id'] = $group['id'];

					$ModuleData['created_by'] = 'admin';

					$ModuleData['updated_by'] = 'admin';

					$this->ModuleService->updateOrCreateModules($ModuleData);
				}
			}
		});
	}

	public function destroy(Group $groups)
	{
		return DB::transaction(function () use ($groups) {
			$groups->modules->each(function ($module) {
				$module->themes->each(function ($theme) {
					$theme->sub_theme()->delete();
				});
				$module->themes()->detach();
				$module->instructors()->detach();

			});

			$groups->modules()->detach();

			$groups->delete();

			return $this->index();
		});
	}
}
