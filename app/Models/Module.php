<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(string[] $array)
 */
class Module extends Model
{
	protected $table = 'modules';
	protected $fillable = [
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
	use HasFactory;

	public function instructor()
	{
		return $this->belongsToMany(Instructor::class, 'modules_instructor', 'group_module_id', 'instructor_id');
	}
	public function themes()
	{
		return $this->belongsToMany(Theme::class, 'modules_themes', 'group_module_id', 'theme_id');
	}
	public function groups(): BelongsToMany
	{
		return $this->belongsToMany(Group::class, 'group_modules', 'group_id', 'modules_id');
	}
}
