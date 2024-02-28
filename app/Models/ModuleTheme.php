<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static create(array $array)
 */
class ModuleTheme extends Model
{
	use HasFactory;

	protected $table = 'module_theme';
	protected $fillable = [
		'module_id',
		'theme_id',
		'created_by',
		'updated_by',
	];
	protected $hidden = [

		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];

	public function themes()
	{
		return $this->hasMany(Theme::class, 'id', 'theme_id');
	}

	public function sub_themes()
	{
		return $this->hasMany(subTheme::class, 'theme_id');
	}

}
