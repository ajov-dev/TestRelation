<?php

namespace App\Services;

use App\Models\Theme;
use App\Models\Module;
use App\Services\SubThemeService;
use Illuminate\Support\Facades\DB;

/**
 * Class ThemeService.
 */
class ThemeService
{
	private Theme $theme;
	private Module $module;
	private SubThemeService $subThemeService;

	public function __construct(Theme $theme, Module $module, SubThemeService $subThemeService)
	{
		$this->theme = $theme;
		$this->module = $module;
		$this->subThemeService = $subThemeService;
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

	public function post()
	{
		//
	}

	public function edit()
	{
		//
	}

	public function update()
	{
		//
	}

	public function destroy()
	{
		//
	}

}
