<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'name',
        'abbr',
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
            'status' => StatusEnum::class,
            'configs' => 'array',
            'metas' => 'array',
        ];
    }
}
