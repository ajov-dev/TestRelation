<?php

namespace App\Http\Controllers;

use App\Services\ThemeService;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
	protected ThemeService $ThemeService;

	public function __construct(ThemeService $ThemeService)
	{
		$this->ThemeService = $ThemeService;
	}
	public function index()
	{
		return $this->ThemeService->index();
	}
}
