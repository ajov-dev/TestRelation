<?php

namespace App\Services;

use App\Http\Resources\ModuleResource;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleInstructor;
use Illuminate\Support\Facades\DB;

/**
 * Class ModuleService.
 */
class ModuleService
{
	protected $ServiceTheme;
	public function __construct(ThemeService $ServiceTheme)
	{
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

	public function updateOrCreateModules(array $req): void
	{
		DB::transaction(function () use ($req) {
			$Module = isset($req['id'])
				? Module::updateOrCreate(['id' => $req['id']], $req)
				: Module::create($req);

			$req['module_id'] = $Module->id;
			$GroupModule = GroupModule::updateOrCreate(['group_id' => $req['group_id'], 'module_id' => $Module->id], $req);

			$req['modules_id'] = $GroupModule->id;
			ModuleInstructor::updateOrCreate(['modules_id' => $req['modules_id']], $req);

			if (isset($req['themes'])) {
				$req['whereNotIn'] = collect($req['themes'])->pluck('id');
				$this->ServiceTheme->destroyThemes($req); // destroy themes
				// foreach ($req['themes'] as $data) {
				// 	$data['created_by'] = $req['created_by'];
				// 	$data['updated_by'] = $req['updated_by'];
				// 	$data['modules_id'] = $req['modules_id'];
				// 	$this->ServiceTheme->updateOrCreateThemes($data);
				// }
			}else{
				$this->ServiceTheme->destroyThemes($req); // destroy themes
			}
		});
	}

	// public function destroyModules($data): void
	// {
	// 	$id_to_delete = collect($data['data'])->pluck('id')->toArray();
	// 	DB::transaction(function () use ($id_to_delete, $data) {
	// 		$groupsModules = GroupModule::where('group_id', $data['id'])
	// 			->whereNotIn('module_id', $id_to_delete)
	// 			->get();
	// 		$groupsModules->each(function ($groupModule) {
	// 			$moduleThemes = ModuleTheme::where('module_id', $groupModule->id)->get();
	// 			$moduleThemes->each(function ($moduleTheme) {
	// 				$subThemes = SubTheme::where('theme_id', $moduleTheme->id)->get();
	// 				$subThemes->each(function ($subTheme) {
	// 					$subTheme->delete();
	// 				});
	// 				$moduleTheme->delete();
	// 			});

	// 			ModuleInstructor::where('module_id', $groupModule->id)->delete();
	// 			// GroupModule::where('id', $groupModule->id)->destroy();
	// 			$groupModule->destroy();
	// 		});
	// 	});

	// }
}
