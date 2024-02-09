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

	public function updateOrCreateThemes(array $DT)
	{
		$this->Theme = isset($DT['id'])
			? Theme::updateOrCreate(['id' => $DT['id']], $DT)
			: Theme::create($DT);
		$DT['theme_id'] = $this->Theme['id'];

		$ModuleTheme = ModuleTheme::updateOrCreate([
			'module_id' => $DT['id'],
			'theme_id' => $this->Theme['id']
		], $DT);

		if (isset($DT['sub_themes'])) {
			$this->subThemeService->destroySubThemes($DT);
			foreach ($DT['sub_themes'] as $DST) {
				$DST['theme_id'] = $ModuleTheme['id'];
				$DST['created_by'] = $DT['created_by'];
				$DST['updated_by'] = $DT['updated_by'];
				$this->subThemeService->updateOrCreateSubThemes($DST);
			}
		}
	}

	public function destroyThemes($data): void
	{
		$themes = collect($data['themes'])->pluck('id')->toArray();
		DB::transaction(function () use ($themes, $data) {
			$ModuleThemes = ModuleTheme::where('module_id', $data['id'])
				->whereNotIn('theme_id', $themes)
				->get();
			$ModuleThemes->each(function ($ModuleTheme) {
				SubTheme::destroy('theme_id', $ModuleTheme->id);
				ModuleTheme::destroy($ModuleTheme->id);
			});
		});
	}
}
