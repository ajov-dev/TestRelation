<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ModuleInstructor extends Model
{
	use HasFactory;

	protected $table = 'modules_instructor';

	protected $fillable = [
		'group_module_id',
		'instructor_id',
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
