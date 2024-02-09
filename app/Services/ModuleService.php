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
	protected $GM;
	protected $Module;
	protected $ModuleInstructor;
	protected $ModuleTheme;
	protected $SubTheme;
	protected $Theme;

	public function __construct(Module $Module, GroupModule $GM, ModuleInstructor $ModuleInstructor, Theme $Theme, SubTheme $SubTheme, ModuleTheme $ModuleTheme)
	{
		$this->GM = $GM;
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

	public function updateOrCreateModules(array $DM)
	{

		return DB::transaction(function () use ($DM) {
			$DM['created_by'] = 'admin';
			$DM['updated_by'] = 'admin';

			$this->Module = isset($DM['id'])
				? Module::updateOrCreate(['id' => $DM['id']], $DM)
				: Module::create($DM);

			$this->GM = GroupModule::updateOrCreate(['group_id' => $DM['group_id'], 'module_id' => $DM['id']], $DM);

			ModuleInstructor::updateOrCreate(['module_id' => $this->GM['id']], ['instructor_id' => (int )$DM['instructor_id']]);


			if (isset($DM['themes'])) {
				//$this->SubTheme->destroyModules($DM); // destroy themes
				foreach ($DM['themes'] as $DT) {
					$DT['created_by'] = $DM['created_by'];
					$DT['updated_by'] = $DM['updated_by'];

					$this->Theme = isset($DT['id'])
						? Theme::updateOrCreate(['id' => $DT['id']], $DT)
						: Theme::create($DT);

					$DT['module_id'] = $DM['id'];
					$DT['theme_id'] = $this->Theme['id'];

					$ModuleTheme = ModuleTheme::updateOrCreate([
						'module_id' => $DM['id'],
						'theme_id' => $this->Theme['id']
					], $DT);

					foreach ($DT['sub_theme'] as $DST) {
						$DST['theme_id'] = $ModuleTheme['id'];
						$DST['created_by'] = $DM['created_by'];
						$DST['updated_by'] = $DM['updated_by'];

						$this->SubTheme = isset($DST['id'])
							? SubTheme::updateOrCreate(['theme_id' => $DST['id']], $DST)
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
				GroupModule::destroy($groupModule->id);
				ModuleTheme::destroy('module_id', $groupModule->id);
				ModuleInstructor::destroy('module_id', $groupModule->id);
			});
		});

	}
}
