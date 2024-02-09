<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
/**
 * @method static create(array $array)
 */
class GroupModule extends pivot
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
		'pivot',
		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];
}
