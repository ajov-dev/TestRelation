<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(string[] $array)
 * @method static where(string $string, int $int)
 * @property mixed $modules
 */
class Group extends Model
{
	use HasFactory;

	protected $table = 'groups';
	protected $fillable = [
		'academic_activity_id',
		'description',
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
		return $this->belongsToMany(Module::class, 'group_modules')
		->using(GroupModule::class)
		->withPivot('id');
	}
}
