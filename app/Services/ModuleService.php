<?php

namespace App\Services;

use App\Http\Resources\ModuleResource;
use App\Models\GroupModule;
use App\Models\Module;
use App\Models\ModuleInstructor;
use App\Models\ModuleTheme;
use App\Models\SubTheme;
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
			'themes'
		])->get();

		return ModuleResource::collection($response);
	}

	public function updateOrCreateModules(array $req): void
	{
		DB::transaction(function () use ($req) {

			$Module = isset ($req['id'])
				? Module::updateOrCreate(['id' => $req['id']], $req)
				: Module::create($req);

			$req['module_id'] = $Module->id;

			$GroupModule = GroupModule::updateOrCreate(['group_id' => $req['group_id'], 'module_id' => $Module->id], $req);

			$req['module_id'] = $GroupModule->id;

			ModuleInstructor::updateOrCreate(['module_id' => $req['module_id']], $req);

			if (isset ($req['themes'])) {

				$req['whereNotIn'] = collect($req['themes'])->pluck('id');

				$this->ServiceTheme->destroyThemes($req); // destroy themes

				foreach ($req['themes'] as $data) {

					$data['created_by'] = $req['created_by'];
					$data['updated_by'] = $req['updated_by'];
					$data['module_id'] = $req['module_id'];

					$this->ServiceTheme->updateOrCreateThemes($data);
				}
			} else {

				$this->ServiceTheme->destroyThemes($req); // destroy themes
			}

		});
	}

	public function destroyModules($req)
	{

		return DB::transaction(function () use ($req) {

			$GroupModules = $req['whereNotIn']->wherenotNull()
			? GroupModule::where('group_id', $req['group_id'])->whereNotIn('module_id', $req['whereNotIn'])->get()
			: GroupModule::where('group_id', $req['group_id'])->get();
			// $GroupModules = GroupModule::where('group_id', $req['group_id'])->get();

			return $GroupModules;
			// $GroupModules->each(function ($GroupModule) {

			// 	$ModuleThemes = ModuleTheme::where('module_id', $GroupModule->id)->get();

			// 	$ModuleThemes->each(function ($ModuleTheme) {

			// 		SubTheme::where('theme_id', $ModuleTheme->id)->get()->delete();
			// 	});

			// 	$ModuleThemes->destroy();

			// 	ModuleInstructor::where('module_id', $GroupModule->id)->delete();

			// });
			// $GroupModules->destroy();
		});

	}
}
