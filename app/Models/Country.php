<?php

namespace App\Models;

use App\Models\Region;
use App\Enums\StatusEnum;
use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    use Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'region_id',
        'name',
        'description',
        'code',
        'alpha3',
        'numeric',
        'phone_code',
        'currency_code',
        'currency_name',
        'flag_url',
        'subregion',
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

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
