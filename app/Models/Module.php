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
		'pivot',
		'created_at',
		'updated_at',
		'created_by',
		'updated_by',
	];

	public function themes()
	{
		return $this->belongsToMany(Theme::class, ModuleTheme::class);
	}

    public function instructor()
    {
        return $this->belongsToMany(Instructor::class, ModuleInstructor::class);
    }

}
