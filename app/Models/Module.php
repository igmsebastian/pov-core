<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Observers\ModuleObserver;
use App\Models\Concerns\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ModuleObserver::class])]
class Module extends Model
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

    public static function allModules(): array
    {
        return self::query()
            ->distinct()
            ->pluck('code')
            ->toArray();
    }
}
