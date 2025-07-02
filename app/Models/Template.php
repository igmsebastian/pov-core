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
        'created_by',
        'created_by_email',
        'updated_by',
        'updated_by_email',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'configs' => 'array',
            'metas' => 'array',
        ];
    }
}
