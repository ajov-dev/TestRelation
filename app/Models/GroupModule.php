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

	protected $table = 'group_modules';
	protected $fillable = [
		'group_id',
		'modules_id',
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

	public function themes()
    {
        return $this->belongsToMany(Theme::class, 'modules_themes');
    }

    // Relación muchos a muchos con instructors a través de modules_instructor
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'modules_instructor');
    }
}
