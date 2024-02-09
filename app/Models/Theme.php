<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(string[] $array)
 * @method static attach(mixed $themeData)
 */
class Theme extends Model
{
	use HasFactory;
	protected $table = 'themes';
	protected $fillable = [
		'description',
		'created_by',
		'updated_by',
	];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'pivot'
	];

	public function sub_theme()
	{
		return $this->hasMany(SubTheme::class, 'theme_id');
	}
}
