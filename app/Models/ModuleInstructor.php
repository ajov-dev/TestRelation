<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @method static create(array $array)
 */
class ModuleInstructor extends Pivot
{
	use HasFactory;

	protected $table = 'module_instructor';

	protected $fillable = [
		'module_id',
		'instructor_id',
		'created_by',
		'updated_by',
	];
	protected $hidden = [
		
		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];
}
