<?php

namespace App\Services;

use App\Http\Resources\ModuleResource;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleInstructor;
use App\Models\ModuleTheme;
use App\Models\SubTheme;
use App\Models\Theme;
use Illuminate\Support\Facades\DB;

/**
 * Class ModuleService.
 */
class ModuleService
{
	protected Module $Module;
	protected GroupModule $GroupModule;
	protected Theme $Theme;
	protected SubTheme $SubTheme;
	protected ModuleInstructor $ModuleInstructor;
	protected ModuleTheme $ModuleTheme;
	protected ThemeService $ServiceTheme;

	public function index()
	{
		$response = Module::with([
			'instructor',
			'themes.sub_theme'
		])->get();

		return ModuleResource::collection($response);
	}

	public function updateOrCreateModules(array $DataModule)
	{
		return DB::transaction(function () use ($DataModule) {
			$DataModule['created_by'] = 'admin';
			$DataModule['updated_by'] = 'admin';

			$this->Module = isset($DataModule['id'])
				? Module::updateOrCreate(['id' => $DataModule['id']], $DataModule)
				: Module::create($DataModule);

			$this->GroupModule = GroupModule::updateOrCreate(['group_id' => $DataModule['group_id'], 'module_id' => $DataModule['id']], $DataModule);

			ModuleInstructor::updateOrCreate(['module_id' => $this->GroupModule['id']], ['instructor_id' => $DataModule['instructor_id']]);

			if (isset($DataModule['themes'])) {
				dd ($this->ServiceTheme->destroyThemes($DataModule)); // destroy themes
				foreach ($DataModule['themes'] as $DT) {
					$DT['created_by'] = $DataModule['created_by'];
					$DT['updated_by'] = $DataModule['updated_by'];
					$DT['module_id'] = $this->GroupModule['id'];
					$this->ServiceTheme->updateOrCreateThemes($DT);
				}
			}
			return [$this->Module];
		});
	}

	public function destroyModules($data)
	{
		$modules = collect($data['data'])->pluck('id')->toArray();
		return dd (DB::transaction(function () use ($modules, $data) {
			$groupsModules = GroupModule::where('group_id', $data['id'])
				->whereNotIn('module_id', $modules)
				->get();

			$groupsModules->each(function ($groupModule) {
				$moduleTheme = ModuleTheme::where('module_id', $groupModule->id)->first();
				SubTheme::where('theme_id', $moduleTheme->id)->delete();
				ModuleTheme::where('module_id', $groupModule->id)->delete();
				ModuleInstructor::where('module_id', $groupModule->id)->delete();
				GroupModule::find($groupModule->id)->delete();
			});

			return $groupsModules;
		}));

	}
}
