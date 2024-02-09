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
	public function updateOrCreateSubThemes(array $DST): void
	{
		DB::transaction(function () use ($DST) {
			$this->SubTheme = isset($DST['id'])
				? SubTheme::updateOrCreate(['theme_id' => $DST['id']], $DST)
				: SubTheme::create($DST);
		});
	}
	public function destroySubThemes($data): void
	{
		$themes = collect($data['sub_themes'])->pluck('id')->toArray();
		DB::transaction(function () use ($themes, $data) {
			$ModuleThemes = SubTheme::where('theme_id', $data['id'])
				->whereNotIn('theme_id', $themes)
				->get();
			$ModuleThemes->each(function ($ModuleTheme) {
				SubTheme::destroy('theme_id', $ModuleTheme->id);
			});
		});
	}
}
