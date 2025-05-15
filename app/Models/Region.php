<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
            'status' => StatusEnum::class,
        ];
    }

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class, 'region_id');
    }
}
