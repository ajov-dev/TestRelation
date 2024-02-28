<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModuleRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			"group_id" => ["required", "integer", "exists:groups,id"],

			"units" => ["sometimes", "required", "array"],
			"units.*.instructor_id" => ["sometimes","required", "integer", "exists:instructors,id"],
			"units.*.themes" => ["sometimes","required", "array"],
			"units.*.themes.*.sub_themes" => ["sometimes","required", "array"],

		];
	}

	public function attributes(): array
	{
		return [
			"group_id" => "ID del Grupo",
			"units" => "Unidades",
			"units.*.instructor_id" => "ID del Instructor",
			"units.*.themes" => "Temas",
			"units.*.themes.*.sub_themes" => "SubTemas",
		];
	}
	public function messages(): array
	{
		return [
			"group_id.required" => "El :attribute es necesario.",
			"group_id.numeric" => "El :attribute debe ser un número entero.",
			"group_id.exists" => "El :attribute no existe en la base de datos.",

			"units.required" => "Las :attribute son necesarias",
			"units.array" => "Las :attribute deben ser un arreglo",

			"units.*.instructor_id.required" => "El :attribute es necesario.",
			"units.*.instructor_id.numeric" => "El :attribute debe ser un número entero.",
			"units.*.instructor_id.exists" => "El :attribute no existe en la base de datos.",

			"units.*.themes.required" => "Los :attribute son necesarias",
			"units.*.themes.array" => "Los :attribute deben ser un arreglo",

			"units.*.themes.*.sub_themes.required" => "Los :attribute son necesarias",
			"units.*.themes.*.sub_themes.array" => "Los :attribute deben ser un arreglo",
		];
	}
}
