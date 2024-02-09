<?php

namespace App\Http\Controllers;

use App\Services\AcademicActivityService;
use Illuminate\Http\Request;

class AcademicActivityController extends Controller
{
	protected AcademicActivityService $academicActivityService;

	public function __construct(AcademicActivityService $academicActivityService)
	{
		$this->academicActivityService = $academicActivityService;
	}
	public function index()
	{
		return $this->academicActivityService->index();
	}
}
