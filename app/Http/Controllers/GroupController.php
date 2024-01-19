<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use Illuminate\Http\Request;
use Exception;

class GroupController extends Controller
{
    private GroupService $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index(): array
    {
        try {
            return $this->groupService->index();
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function store(Request $request): array
    {
        $rules = [
            'code' => 'required|string|max:255',
            'layout_of_certificate' => 'required|integer',
            'certificate_by' => 'required|string|max:255',
            'finish_date_inscription' => 'required|date_format:d/m/Y',
            'description' => 'required|string|max:255',
            'academic_activity_id' => 'required|integer',
            'requested_meals' => 'required|integer',
            'course_time_in_days' => 'required|integer',
            'amount_inscription' => 'required|numeric',
            'units' => 'required|array',
            'units.*.instructor_id' => 'required|string|max:255',
            'units.*.description' => 'required|string|max:255',
            'units.*.created_by' => 'required|string|max:255',
            'units.*.updated_by' => 'required|string|max:255',
            'units.*.themes' => 'required|array',
            'units.*.themes.*.description' => 'required|string|max:255',
            'units.*.themes.*.created_by' => 'required|string|max:255',
            'units.*.themes.*.updated_by' => 'required|string|max:255',
            'units.*.themes.*.subThemes' => 'required|array',
            'units.*.themes.*.subThemes.*.description' => 'string|max:255',
            'units.*.themes.*.subThemes.*.created_by' => 'string|max:255',
            'units.*.themes.*.subThemes.*.updated_by' => 'string|max:255',
            'schedule' => 'required|array',
            'schedule.workload' => 'required|integer',
            'schedule.start_date' => 'nullable|date_format:d/m/Y',
            'schedule.finish_date' => 'nullable|date_format:d/m/Y',
            'schedule.description' => 'nullable|string|max:255',
            'created_by' => 'required|string|max:255',
            'updated_by' => 'required|string|max:255',
        ];

        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'date_format' => 'El campo :attribute debe tener el formato :format.',
        ];

        try {
            //return $this->groupService->store($request->validate($rules, $messages));
            return $this->groupService->storeGroup($request->all());

        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function show(int $id): array
    {
        try {
            return $this->groupService->show($id);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function update(Request $request, int $id): array
    {
        try {
            return $this->groupService->update($request->all(), $id);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function destroy(int $id): array
    {
        try {
            return $this->groupService->destroy($id);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }


}
