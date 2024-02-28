<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class GroupModule extends Model
{
	use HasFactory;

	protected $table = 'group_module';
	protected $fillable = [
		'group_id',
		'module_id',
		'created_by',
		'updated_by'
	];
	protected $hidden = [

		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];
	// public function modules()
	// {
	// 	return $this->belongsToMany(Module::class);
	// }
	// public function groups()
	// {
	// 	return $this->belongsToMany(Group::class);
	// }
	// public function module_themes()
	// {
	// 	return $this->hasMany(ModuleTheme::class, 'module_id');
	// }
	// public function module_instructors()
	// {
	// 	return $this->belongsToMany(Instructor::class, ModuleInstructor::class, 'module_id', 'instructor_id');
	// }

	public function themes()
	{
		return $this->belongsToMany(Theme::class, 'module_theme', 'module_id', 'theme_id')
			->with('sub_themes');
	}

	public function instructors()
	{
		return $this->belongsToMany(Instructor::class, 'module_instructor', 'module_id', 'instructor_id');
	}
}
