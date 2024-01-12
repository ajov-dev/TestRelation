<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(string[] $array)
 */
class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'created_by',
        'updated_by',
    ];

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class, 'modules_instructor', 'instructor_id', 'modules_id');
    }
}
