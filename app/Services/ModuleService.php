<?php

namespace App\Services;

use App\Http\Resources\ModuleResource;
use App\Models\Group;
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

	public function __construct(
		Module $Module,
		GroupModule $GroupModule,
		Theme $Theme,
		SubTheme $SubTheme,
		ModuleInstructor $ModuleInstructor,
		ModuleTheme $ModuleTheme,
		ThemeService $ServiceTheme
	) {
		$this->Module = $Module;
		$this->GroupModule = $GroupModule;
		$this->Theme = $Theme;
		$this->SubTheme = $SubTheme;
		$this->ModuleInstructor = $ModuleInstructor;
		$this->ModuleTheme = $ModuleTheme;
		$this->ServiceTheme = $ServiceTheme;
	}

	public function index()
	{
		$response = Module::with([
			'instructors',
			'themes.sub_theme'
		])->get();

		return ModuleResource::collection($response);
	}

	public function updateOrCreateModules(array $DataModule): void
	{
		DB::transaction(function () use ($DataModule) {
			$this->Module = isset($DataModule['id'])
				? Module::updateOrCreate(['id' => $DataModule['id']], $DataModule)
				: Module::create($DataModule);

			$this->GroupModule = GroupModule::updateOrCreate(['group_id' => $DataModule['group_id'], 'module_id' => $DataModule['id']], $DataModule);

			ModuleInstructor::updateOrCreate(['module_id' => $this->GroupModule['id']], ['instructor_id' => $DataModule['instructor_id']]);

			if (isset($DataModule['themes'])) {
				//$this->ServiceTheme->destroyThemes($DataModule); // destroy themes
				foreach ($DataModule['themes'] as $DataTheme) {
					$DataTheme['created_by'] = $DataModule['created_by'];
					$DataTheme['updated_by'] = $DataModule['updated_by'];
					$DataTheme['module_id'] = $this->GroupModule['id'];
					$this->ServiceTheme->updateOrCreateThemes($DataTheme);
				}
			}
			//return [$this->Module];
		});
	}

	public function destroyModules($data): void
	{
		$modules = collect($data['data'])->pluck('id')->toArray();
		DB::transaction(function () use ($modules, $data) {
			$groupsModules = GroupModule::where('group_id', $data['id'])
				->whereNotIn('module_id', $modules)
				->get();
			$groupsModules->each(function ($groupModule) {
				$moduleThemes = ModuleTheme::where('module_id', $groupModule->id)->get();
				$moduleThemes->each(function ($moduleTheme) {
					$subThemes = SubTheme::where('theme_id', $moduleTheme->id)->get();
					$subThemes->each(function ($subTheme) {
						$subTheme->delete();
					});
					$moduleTheme->delete();
				});

				ModuleInstructor::where('module_id', $groupModule->id)->delete();
				// GroupModule::where('id', $groupModule->id)->destroy();
				$groupModule->destroy();
			});
		});

	}
}
