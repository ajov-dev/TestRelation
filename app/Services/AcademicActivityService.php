<?php

namespace App\Services;

use App\Models\AcademicActivity;
use App\Http\Resources\AcademicActivityResource;
/**
 * Class AcademicActivityService.
 */
class AcademicActivityService
{
    public function index()
    {
		$collection = AcademicActivity::all();
		return AcademicActivityResource::collection($collection);
    }

    public function create()
    {
        //
    }

    public function show()
    {
        //
    }

    public function post()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }

}
