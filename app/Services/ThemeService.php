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
		$this->Theme = isset($req['id'])
			? Theme::updateOrCreate(['id' => $req['id']], $req)
			: Theme::create($req);

		$req['themes_id'] = $this->Theme['id'];

		$ModuleTheme = ModuleTheme::updateOrCreate([
			'modules_id' => $req['modules_id'],
			'theme_id' => $this->Theme['id']
		]);

		if (isset($req['sub_themes'])) {
			//$this->subThemeService->destroySubThemes($req);
			foreach ($req['sub_themes'] as $data) {
				$data['themes_id'] = $ModuleTheme['id'];
				$data['created_by'] = $req['created_by'];
				$data['updated_by'] = $req['updated_by'];
				$this->subThemeService->updateOrCreateSubThemes($data);
			}
		}
	}

	public function destroyThemes($data): void
	{
		$id_to_delete = collect($data['themes'])->pluck('id')->toArray();
		DB::transaction(function () use ($id_to_delete, $data) {
			$ModuleThemes = ModuleTheme::where('module_id', $data['id'])
				->whereNotIn('theme_id', $id_to_delete)
				->get();
			$ModuleThemes->each(function ($ModuleTheme) {
				SubTheme::destroy('theme_id', $ModuleTheme->id);
				ModuleTheme::destroy($ModuleTheme->id);
			});
		});
	}
}
