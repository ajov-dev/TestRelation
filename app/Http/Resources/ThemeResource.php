<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThemeResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'descripcion' => $this->description,
			'sub_themes' => SubThemeResource::collection(collect($this->sub_themes)->pluck('sub_themes')->flatten()),
		];
	}
}
