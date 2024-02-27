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
			'description' => $this->description,
			'instructor_id' => collect($this->instructors)->pluck('instructors')->flatten()->value('id'),
			'themes' => ThemeResource::collection(collect($this->themes)->pluck('themes')->flatten())
		];
    }
}
