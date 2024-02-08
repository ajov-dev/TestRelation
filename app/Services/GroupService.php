<?php

namespace App\Services;

use App\Models\Group;
use App\Models\GroupModule;
use App\Models\ModuleInstructor;
use App\Models\ModuleTheme;
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
			'grupos' => Group::latest()->with([
				'modules' => function ($query) {
					$query->with(['instructor', 'themes.sub_themes']);
				}
			])->get()
		];
	}

	public function storeGroups($data): void
	{
		$this->ModuleService->destroyModules($data);

		$group = Group::find($data['group_id']);

		foreach ($data['units'] as $ModuleData) {

			$ModuleData['group_id'] = $group->id;

			$this->ModuleService->updateOrCreateModule($ModuleData);
		}
	}
}
