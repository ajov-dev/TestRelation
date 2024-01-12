<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubTheme extends Model
{
    use HasFactory;

    protected  $table = 'themes';
    protected $fillable = [
        'themes_id',
        'description',
        'created_by',
        'updated_by',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'themes_id')->whereNull('themes_id');
    }
}
