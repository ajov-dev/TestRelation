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
			'modules' => function ($q) {
				$q->with([
					'instructor',
					'themes.sub_theme'
				]);
			}
		])->get();

		return GroupResource::collection($response);
	}
	public function store(array $data): void
	{
		DB::transaction(function () use ($data) {
			$group = Group::find($data['id']);
			$this->ModuleService->destroyModules($data);
			foreach ($data['data'] as $ModuleData) {
				$ModuleData['group_id'] = $group['id'];
				$this->ModuleService->updateOrCreateModules($ModuleData);
			}
		});
	}
}
