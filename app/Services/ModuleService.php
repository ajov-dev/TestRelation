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
	protected $GroupModule;
	protected $Module;
	protected $ModuleInstructor;
	protected $ModuleTheme;
	protected $SubTheme;
	protected $Theme;

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

	public function updateOrCreateModule(array $DataModule)
	{
		return DB::transaction(function () use ($DataModule) {
			$DataModule['created_by'] = 'admin';
			$DataModule['updated_by'] = 'admin';

			$this->module = isset($DataModule['id'])
			? Module::updateOrCreate(['id' => $DataModule['id']], $DataModule)
			: Module::create($DataModule);

			$GroupModule = GroupModule::updateOrCreate(['group_id' => $DataModule['group_id'], 'modules_id' => $DataModule['id']], $DataModule);

			ModuleInstructor::updateOrCreate(['group_module_id' => $GroupModule['id']], ['instructor_id' => $DataModule['instructor_id']]);

			if (isset($DataModule['themes'])) {
				foreach ($DataModule['themes'] as $DataThemes) {
					$DataThemes['created_by'] = $DataModule['created_by'];
					$DataThemes['updated_by'] = $DataModule['updated_by'];

					$this->Theme = isset($DataThemes['id'])
					? Theme::updateOrCreate(['id' => $DataThemes['id']], $DataThemes)
					: Theme::create($DataThemes);

					$DataThemes['modules_id'] = $DataModule['id'];
					$DataThemes['themes_id'] = $this->Theme['id'];
					ModuleTheme::updateOrCreate([
						'modules_id' => $DataModule['id'],
						'themes_id' => $DataThemes['themes_id']
					], $DataThemes);

					foreach ($DataThemes['sub_themes'] as $DataSubThemes) {
						$DataSubThemes['theme_id'] = $this->Theme['id'];
						$DataSubThemes['created_by'] = $DataModule['created_by'];
						$DataSubThemes['updated_by'] = $DataModule['updated_by'];

						$this->SubTheme = isset($DataSubThemes['id'])
						? SubTheme::updateOrCreate(['id' => $DataSubThemes['id']], $DataSubThemes)
						: SubTheme::create($DataSubThemes);
					}
				}
			}
			return [$this->Module];
		});
	}
}
