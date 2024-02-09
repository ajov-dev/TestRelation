<?php

namespace App\Services;

use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use App\Models\Module;
use App\Services\SubThemeService;
use Illuminate\Support\Facades\DB;

/**
 * Class ThemeService.
 */
class ThemeService
{
	protected Theme $theme;
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
	public function show(int $id): array
	{
		return [$this->module::where('id', $id)->with('themes.subThemes')->get()];
	}

	public function storeTheme(array $moduleData, int $module_id): array
	{
		return DB::transaction(function () use ($moduleData, $module_id) {
			foreach ($moduleData['themes'] as $themeData) {

				$this->theme = Theme::create($themeData);

				$this->module->themes()->attach([['theme_id' => $this->theme['id'], 'module_id' => $module_id, 'created_by' => $themeData['created_by'], 'updated_by' => $themeData['updated_by']]]);

				$this->subThemeService->storeSubTheme($themeData, $this->theme['id']);
			}

			return [$this->show($module_id)];
		});
	}


}
