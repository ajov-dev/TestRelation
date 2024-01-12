<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ModuleInstructor extends Model
{
    use HasFactory;

    protected $table = 'modules_instructor';

    protected $fillable = [
        'modules_id',
        'instructor_id',
        'created_by',
        'updated_by',
    ];
}
