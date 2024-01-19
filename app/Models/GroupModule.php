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
        'modules_id'
    ];
}
