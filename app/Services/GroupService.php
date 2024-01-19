<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Module;
use App\Models\Theme;
use App\Models\SubTheme;
use Exception as ExceptionAlias;
use Illuminate\Support\Facades\DB;

/**
 * Class GroupService.
 */
class GroupService
{
	private Group $group;
	private Module $module;
	private Theme $theme;

	private ThemeService $ThemeService;

	public function __construct(Group $group, Module $module, Theme $theme, ThemeService $ThemeService)
	{
		$this->group = $group;
		$this->module = $module;
		$this->theme = $theme;
		$this->ThemeService = $ThemeService;
	}

	public function index(): array
	{
		return [
			'grupos' => Group::with(['modules.themes.subThemes'])->get()
		];
	}

	public function store(array $request): array
	{
		$this->group = Group::create($request);
		return $this->group->toArray();
	}

	public function storeGroup(array $data): array
	{
		return DB::transaction(function () use ($data) {
			$this->store($data);

			foreach ($data['units'] as $moduleData) {

				$this->module = Module::create($moduleData);

				$this->module->instructor()->attach([['instructor_id' => $moduleData['instructor_id'], 'modules_id' => $this->module['id'], 'created_by' => $this->group['created_by'], 'updated_by' => $this->group['updated_by']]]);

				$this->group->modules()->attach([['modules_id' => $this->module['id'], 'group_id' => $this->group['id'], 'created_by' => $this->group['created_by'], 'updated_by' => $this->group['updated_by']]]);

				$this->ThemeService->storeTheme($moduleData, $this->module['id']);
			}

			return [$this->index()];
		});
	}
}
