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
	protected $module;
	public function __construct(Module $module)
	{
		$this->module = $module;
	}
	public function index()
	{
		return [
			'modules' => Module::all()
		];
	}

	public function storeModule(array $DataModule)
	{
		return DB::transaction(function () use ($DataModule) {
			$DataModule['created_by'] = 'admin';
			$DataModule['updated_by'] = 'admin';

			if (isset($DataModule['id'])) {
				$this->module = Module::updateOrCreate(['id' => $DataModule['id']], $DataModule);
			} else {
				$this->module = Module::create($DataModule);
			}
			$GroupModule = GroupModule::updateOrCreate(
				[
					'group_id' => $DataModule['group_id'],
					'modules_id' => $this->module->id
				],
				$DataModule
			);
			ModuleInstructor::updateOrCreate([
				'group_module_id' => $GroupModule->id,
				'instructor_id' => $DataModule['instructor_id']
			], $DataModule);

			foreach ($DataModule['themes'] as $DataThemes) {
				$DataThemes['created_by'] = $DataModule['created_by'];
				$DataThemes['updated_by'] = $DataModule['updated_by'];
				if (isset($DataThemes['id'])) {
					$ModuleTheme = Theme::updateOrCreate(['id' => $DataThemes['id']], $DataThemes);
				} else {
					$ModuleTheme = Theme::create($DataThemes);
				}
				$DataThemes['modules_id'] = $this->module['id'];
				$DataThemes['themes_id'] = $ModuleTheme['id'];
				ModuleTheme::updateOrCreate([
					'modules_id' => $DataModule['id'],
					'themes_id' => $DataThemes['themes_id']
				], $DataThemes);

				foreach ($DataThemes['sub_themes'] as $DataSubThemes) {
					$DataSubThemes['theme_id'] = $ModuleTheme['id'];
					$DataSubThemes['created_by'] = $DataModule['created_by'];
					$DataSubThemes['updated_by'] = $DataModule['updated_by'];
					if (isset($DataSubThemes['id'])) {
						SubTheme::updateOrCreate(['id' => $DataSubThemes['id']], $DataSubThemes);
					} else {
						SubTheme::create($DataSubThemes);
					}
				}
			}
			return $this->module;
		});
	}
}
