<?php

namespace App\Models;

use App\Enums\FeatureTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            'configs' => 'object',
            'metas' => 'object',
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
