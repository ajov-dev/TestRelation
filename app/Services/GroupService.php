<?php

namespace App\Services;

use App\Models\Group;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleInstructor;
use App\Models\ModuleTheme;
use App\Models\SubTheme;
use App\Models\AcademicActivity;
use App\Services\ModuleService;
use Illuminate\Support\Facades\DB;

/**
 * Class GroupService.
 */
class GroupService
{

	public const create_by = 'admin';
	public const update_by = 'admin';

	protected $group;
	protected $ModuleService;

	public function __construct(Group $group, ModuleService $ModuleService)
	{
		$this->group = $group;
		$this->ModuleService = $ModuleService;
	}

	public function index()
	{
		return [
			'academic_activity_id' => AcademicActivity::with([
				'groups' => function ($q){
					$q->with([
						'modules' => function ($q){
							$q->with([
								'instructor', 'themes.sub_themes']);
						}
					]);
				}
			])->find(1),
		];
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
