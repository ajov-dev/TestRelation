<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @method static create(array $array)
 */
class ModuleTheme extends Pivot
{
	use HasFactory;

	protected $table = 'module_theme';
	protected $fillable = [
		'module',
		'theme_id',
		'created_by',
		'updated_by',
	];
	protected $hidden = [
		'pivot',
		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];
}
