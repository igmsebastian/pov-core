<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'feature_id',
        'module_id',
        'name',
        'code',
        'description',
        'raw',
        'status',
        'configs',
        'metas',
    ];

    protected $casts = [
        'configs' => 'array',
        'metas' => 'array',
    ];
}
