<?php

namespace App\Services;

use App\Http\Resources\SubThemeResource;
use App\Models\SubTheme;
use App\Models\Theme;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class SubThemeService.
 */
class SubThemeService
{
    private $subTheme;

    public function __construct(SubTheme $subTheme)
    {
        $this->subTheme = $subTheme;

    }

	public function index()
	{
		$response = SubTheme::get();

		return SubThemeResource::collection($response);
	}

    public function storeSubTheme(array $arraySubTheme, int $themeID): array
    {
        return DB::transaction(function () use ($arraySubTheme, $themeID) {
            foreach ($arraySubTheme['subThemes'] as $subThemeData) {

                $subThemeData['theme_id'] = $themeID;

                Subtheme::create($subThemeData);
            }

            return [
                'subThemes' => Theme::where('id', $themeID)->with('subThemes')->get()
            ];
        });

    }

    public function update(int $id)
    {

    }

    public function destroy()
    {
        //
    }

}
