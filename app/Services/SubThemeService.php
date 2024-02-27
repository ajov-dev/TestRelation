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
			isset($DataSubTheme['id'])
				? SubTheme::updateOrCreate(['themes_id' => $DataSubTheme['id']], $DataSubTheme)
				: SubTheme::create($DataSubTheme);
		});
	}
	public function destroySubThemes($data): void
	{
		DB::transaction(function () use ( $data ) {
			isset($req['whereNotIn'])
			? SubTheme::where('themes_id', $data['themes_id'])->whereNotIn('id', $data['whereNotIn'])->delete()
			: SubTheme::where('themes_id', $data['themes_id'])->delete();
		});
	}
}
