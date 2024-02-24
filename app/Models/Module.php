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
	use HasFactory;
	protected $table = 'modules';
	protected $fillable = [
		'description',
		'created_by',
		'updated_by',
	];
	protected $hidden = [

		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];
	// public function themes()
	// {
	// 	return $this->hasManyThrough(GroupModule::class, ModuleTheme::class, 'track1', 'track2');
	// // }

	// public function module_themes()
	// {
	// 	return $this->hasManyThrough(ModuleTheme::class, GroupModule::class, 'module_id', 'modules_id');
	// }

	public function group_modules()
	{
		return $this->hasMany(GroupModule::class, 'module_id');
	}
}
