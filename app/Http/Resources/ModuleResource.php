<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // $response
        $module_themes = collect($this->group_modules)->pluck('module_themes')->flatten();

		$themes = collect($module_themes)->pluck('themes')->flatten()->flatten();
		$sub_themes = collect($module_themes)->pluck('sub_themes')->flatten();

		$array = [];
		$array =[
			'themes' => [
				'id' =>$themes[0]->id,
				'description' => $themes[0]->description,
				'sub_themes' => $sub_themes
			]
		];

        return [
            'id' => $this->id,
            'description' => $this->description,
            'group_modules' => $array['themes'],
        ];
    }
}
