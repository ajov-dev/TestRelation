<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(string[] $array)
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

    public function modules(): BelongsToMany
    {
        return $this->BelongsToMany(Module::class, 'modules_themes', 'themes_id', 'modules_id');
    }

    public function subThemes(): HasMany {
        return $this->HasMany(Theme::class, 'themes_id');
    }

    public function parentTheme(): BelongsTo {
        return $this->BelongsTo(Theme::class, 'themes_id');
    }
}
