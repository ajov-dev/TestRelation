<?php

namespace App\Services;

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
		$academicActivity  = AcademicActivity::with([
			'groups' => function ($q) {
				$q->with([
					'modules' => function ($q) {
						$q->with([
							'instructor',
							'themes.sub_theme',
						]);
					}
				]);
			}
		])->get();

		return AcademicActivityResource::collection($academicActivity);
 	}



	public function storeGroups(array $data): void
	{
		DB::transaction(function () use ($data) {
			$this->ModuleService->destroyModules($data);

			$group = Group::find($data['group_id']);

			foreach ($data['units'] as $ModuleData) {

				$ModuleData['group_id'] = $group->id;

				$this->ModuleService->updateOrCreateModules($ModuleData);
			}
		});
	}
}
