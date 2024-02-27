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

	protected $table = 'module_instructor';

	protected $fillable = [
		'modules_id',
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
