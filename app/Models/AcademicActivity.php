<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(string[] $array)
 */
class AcademicActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'created_by',
        'updated_by',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }
}
