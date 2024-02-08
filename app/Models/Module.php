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

    // Relación muchos a muchos con groups a través de group_modules
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_modules');
    }

    // Relación muchos a muchos con themes a través de modules_themes
    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'modules_themes', 'group_module_id', 'theme_id');
    }

    // Relación muchos a muchos con instructors a través de modules_instructor
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'modules_instructor', 'group_module_id', 'instructor_id');
    }


}
