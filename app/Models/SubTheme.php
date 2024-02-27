<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static create(array $subTheme)
 */
class SubTheme extends Model
{
	use HasFactory;

	protected $table = 'sub_theme';
	protected $fillable = [
		'themes_id',
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
}
