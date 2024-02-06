<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(string[] $array)
 */
class Instructor extends Model
{
	use HasFactory;
	protected $table = 'instructors';
	protected $fillable = [
		'firstname',
		'lastname',
	];

	protected $hidden = [
		'pivot',
		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];

	public function modules()
	{
		return $this->belongsToMany(GroupModule::class, 'modules_instructor', 'instructor_id', 'group_module_id');
	}
}
