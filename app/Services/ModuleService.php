<?php

namespace App\Services;

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
	// constructor
	protected GroupModule $GroupModule;
	protected Module $Module;
	protected ModuleInstructor $ModuleInstructor;
	protected ModuleTheme $ModuleTheme;
	protected SubTheme $SubTheme;
	protected Theme $Theme;

	public function __construct(Module $Module, GroupModule $GroupModule, ModuleInstructor $ModuleInstructor, Theme $Theme, SubTheme $SubTheme, ModuleTheme $ModuleTheme)
	{
		$this->GroupModule = $GroupModule;
		$this->Module = $Module;
		$this->ModuleInstructor = $ModuleInstructor;
		$this->ModuleTheme = $ModuleTheme;
		$this->SubTheme = $SubTheme;
		$this->Theme = $Theme;
	}
	public function index()
	{
		return [
			'modules' => Module::all()
		];
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


			ModuleInstructor::updateOrCreate(['module_id' => $this->GroupModule['id']], ['instructor_id' => $DataModule['instructor_id']['id'], ]);

			if (isset($DataModule['themes'])) {
				//$this->destroyThemes($DataModule); // destroy themes
				foreach ($DataModule['themes'] as $DT) {
					$DT['created_by'] = $DataModule['created_by'];
					$DT['updated_by'] = $DataModule['updated_by'];

					$this->Theme = isset($DT['id'])
						? Theme::updateOrCreate(['id' => $DT['id']], $DT)
						: Theme::create($DT);

					$DT['module_id'] = $DataModule['id'];
					$DT['theme_id'] = $this->Theme['id'];

					$ModuleTheme = ModuleTheme::updateOrCreate([
						'module_id' => $DataModule['id'],
						'theme_id' => $this->Theme['id']
					], $DT);

					foreach ($DT['sub_themes'] as $DST) {
						$DST['theme_id'] = $ModuleTheme['id'];
						$DST['created_by'] = $DataModule['created_by'];
						$DST['updated_by'] = $DataModule['updated_by'];

						$this->SubTheme = isset($DST['id'])
							? SubTheme::updateOrCreate(['theme_id' => $ModuleTheme['id']], $DST)
							: SubTheme::create($DST);
					}
				}
			}
			return [$this->Module];
		});
	}

	public function destroyModules($data): void
	{
		$modules = collect($data['units'])->pluck('id')->toArray();

		DB::transaction(function () use ($modules, $data) {
			$groupsModules = GroupModule::where('group_id', $data['group_id'])
				->whereNotIn('module_id', $modules)
				->get();

			$groupsModules->each(function ($groupModule) {
				$moduleTheme = ModuleTheme::where('module_id', $groupModule->id)->first();
				// $moduleTheme->destroy();
				SubTheme::where('theme_id', $moduleTheme->id)->delete();
				ModuleTheme::where('module_id', $groupModule->id)->delete();
				ModuleInstructor::where('module_id', $groupModule->id)->delete();
				GroupModule::find($groupModule->id)->delete();
			});
		});

	}

	public function destroyThemes($data): void
	{
		$themes = collect($data['themes'])->pluck('id')->toArray();

		DB::transaction(function () use ($themes, $data) {
			$ModuleThemes = ModuleTheme::where('module_id', $data['id'])
				->whereNotIn('theme_id', $themes)
				->get();

			$ModuleThemes->each(function ($ModuleTheme) {
				SubTheme::destroy('theme_id',$ModuleTheme->id);
				ModuleTheme::destroy($ModuleTheme->id);
			});
		});

	}

	public function destroySubThemes($data): void
	{
		$themes = collect($data['sub_themes'])->pluck('id')->toArray();

		DB::transaction(function () use ($themes, $data) {
			$ModuleThemes = SubTheme::where('theme_id', $data['id'])
				->whereNotIn('theme_id', $themes)
				->get();

			$ModuleThemes->each(function ($ModuleTheme) {
				SubTheme::destroy('theme_id',$ModuleTheme->id);
			});
		});

	}
}
