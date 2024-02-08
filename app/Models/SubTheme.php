<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $subTheme)
 */
class SubTheme extends Model
{
	use HasFactory;

	protected $table = 'sub_themes';
	protected $fillable = [
		'module_theme_id',
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
        return $this->belongsToMany(ModuleTheme::class, 'themes', 'module_theme_id', 'theme_id');
    }
}
