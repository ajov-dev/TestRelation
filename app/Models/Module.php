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

    protected $fillable = [
        'description',
        'created_by',
        'updated_by',
    ];

    public function groups(): BelongsToMany
    {
        return $this->BelongsToMany(Group::class, 'group_modules', 'modules_id', 'group_id');
    }

    public function instructor(): BelongsToMany
    {
        return $this->BelongsToMany(Instructor::class, 'modules_instructor', 'modules_id', 'instructor_id');
    }

    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'modules_themes', 'modules_id', 'themes_id');
    }

}
