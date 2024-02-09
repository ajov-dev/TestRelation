<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @method static create(array $subTheme)
 */
class SubTheme extends Pivot
{
	use HasFactory;

	protected $table = 'sub_theme';
	protected $fillable = [
		'theme_id',
		'description',
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
