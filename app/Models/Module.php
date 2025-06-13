<?php

namespace App\Models;

class Module extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'name',
        'code',
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
            'configs' => 'object',
            'metas' => 'object',
        ];
    }

    public static function allModules(): array
    {
        return self::query()
            ->distinct()
            ->pluck('code')
            ->toArray();
    }
}
