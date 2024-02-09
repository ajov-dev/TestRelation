<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
			// 'instructor' => InstructorResource::collection($this->instructor),
			'instructor' => $this->instructor[0]->id,
			'themes' => ThemeResource::collection($this->themes),
		];
    }
}
