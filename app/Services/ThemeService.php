<?php

namespace App\Services;

use App\Http\Resources\ThemeResource;
use App\Models\ModuleTheme;
use App\Models\SubTheme;
use App\Models\Theme;
use App\Models\Module;
use App\Services\SubThemeService;
use Illuminate\Support\Facades\DB;

/**
 * Class ThemeService.
 */
class ThemeService
{
	protected Theme $Theme;
	protected Module $module;
	protected SubThemeService $subThemeService;

	public function __construct(Theme $theme, Module $module, SubThemeService $subThemeService)
	{
		$this->theme = $theme;
		$this->module = $module;
		$this->subThemeService = $subThemeService;
	}
	public function index()
	{
		$response = Theme::with('sub_theme')->get();
		return ThemeResource::collection($response);
	}

	public function updateOrCreateThemes(array $req)
	{
		$Theme = isset($req['id'])
			? Theme::updateOrCreate(['id' => $req['id']], $req)
			: Theme::create($req);

		$req['theme_id'] = $Theme['id'];

		$ModuleTheme = ModuleTheme::updateOrCreate([
			'modules_id' => $req['modules_id'],
			'theme_id' => $Theme['id']
		]);

		$req['themes_id'] = $ModuleTheme->id;

		if (isset($req['sub_themes'])) {
			$req['whereNotIn'] = collect($req['sub_themes'])->pluck('id');
			$this->subThemeService->destroySubThemes($req);
			foreach ($req['sub_themes'] as $data) {
				$data['themes_id'] = $req['themes_id'];
				$data['created_by'] = $req['created_by'];
				$data['updated_by'] = $req['updated_by'];
				$this->subThemeService->updateOrCreateSubThemes($data);
			}
		} else {
			$this->subThemeService->destroySubThemes($req);
		}
	}

	public function destroyThemes($data)
	{

		return DB::transaction(function () use ($data) {
			$ModuleThemes = isset($req['whereNotIn'])
			? ModuleTheme::where('modules_id', $data['modules_id'])->whereNotIn('theme_id', $data['whereNotIn'])->get()
			: ModuleTheme::where('modules_id', $data['modules_id'])->get();

			// $ModuleThemes->each(function ($ModuleTheme) {
			// 	SubTheme::destroy('themes_id', $ModuleTheme->id);
			// 	ModuleTheme::destroy($ModuleTheme->id);
			// });
			return dd($data);
		});
	}
}
