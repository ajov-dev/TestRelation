<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'descripcion' => $this->description,
			// 'themes' => ThemeResource::collection(collect($this->module_themes)->pluck('themes')->flatten()),
			'themes' => $this->module_themes,
		];
	}
}
