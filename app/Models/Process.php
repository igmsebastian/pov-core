<?php

namespace App\Models;

class Process extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'module_id',
        'country',
        'name',
        'description',
        'status',
        'configs',
        'metas',
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
