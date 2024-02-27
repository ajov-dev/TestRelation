<?php

namespace App\Services;

use App\Http\Resources\SubThemeResource;
use App\Models\SubTheme;
use Illuminate\Support\Facades\DB;

/**
 * Class SubThemeService.
 */
class SubThemeService
{
	private SubTheme $subTheme;
	public function __construct(SubTheme $subTheme)
	{
		$this->subTheme = $subTheme;
	}
	public function index()
	{
		$response = SubTheme::get();
		return SubThemeResource::collection($response);
	}
	public function updateOrCreateSubThemes(array $DataSubTheme): void
	{
		DB::transaction(function () use ($DataSubTheme) {
			$this->SubTheme = isset($DataSubTheme['id'])
				? SubTheme::updateOrCreate(['themes_id' => $DataSubTheme['id']], $DataSubTheme)
				: SubTheme::create($DataSubTheme);
		});
	}
	public function destroySubThemes($data): void
	{
		$id_to_delete = collect($data['sub_themes'])->pluck('id')->toArray();
		DB::transaction(function () use ($id_to_delete, $data) {
			$ModuleThemes = SubTheme::where('theme_id', $data['id'])
				->whereNotIn('theme_id', $id_to_delete)
				->get();
			$ModuleThemes->each(function ($ModuleTheme) {
				SubTheme::destroy('theme_id', $ModuleTheme->id);
			});
		});
	}
}
