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

		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];

	public function modules()
	{
		return $this->belongsToMany(Module::class, GroupModule::class)
		->withPivot('id as modules_id');
	}

	public function group_modules()
	{
		return $this->hasMany(GroupModule::class);
	}

	// belongs to many -> Groups->modules
	// primer parametro: modelo con el que se relaciona
	// segundo parametro: tabla intermedia
	// tercer parametro: llave foranea del modelo actual
	// cuarto parametro: llave foranea del modelo con el que se relaciona

	// el tercer parametro dice que la llave foranea de este modelo es group_id y ahi es donde estara el id del modelo actual.
}
