<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Enums\FeatureTypeEnum;
use App\Observers\FeatureObserver;
use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([FeatureObserver::class])]
class Feature extends Model
{
    use Filterable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'name',
        'code',
        'type',
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
            'type' => FeatureTypeEnum::class,
            'status' => StatusEnum::class,
            'configs' => 'array',
            'metas' => 'array',
        ];
    }

    public static function getCodeCountryPairs(): array
    {
        return self::query()
            ->select(['code', 'country'])
            ->get()
            ->map(function ($feature) {
                return [
                    'code' => $feature->code,
                    'country' => $feature->country,
                ];
            })
            ->all();
    }
}
