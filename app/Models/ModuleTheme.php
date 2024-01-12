<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ModuleTheme extends Model
{
    use HasFactory;

    protected $table = 'modules_themes';
    protected $fillable = [
        'modules_id',
        'themes_id',
        'created_by',
        'updated_by',
    ];

}
