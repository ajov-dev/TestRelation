<?php

namespace App\Http\Controllers;

use App\Services\SubThemeService;
use Illuminate\Http\Request;

class SubThemeController extends Controller
{
	protected SubThemeService $subThemeService;

	public function __construct(SubThemeService $subThemeService)
	{
		$this->subThemeService = $subThemeService;
	}
	public function index()
	{
		return $this->subThemeService->index();
	}
}
