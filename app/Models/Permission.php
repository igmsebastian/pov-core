<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use App\Observers\PermissionObserver;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([PermissionObserver::class])]
class Permission extends Model
{
    use HasUlids, Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'action',
        'resource',
        'description',
        'category',
        'scope',
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

    public static function allAbilities(): array
    {
        return self::query()
            ->get(['resource', 'action'])
            ->map(fn($p) => "{$p->resource}:{$p->action}")
            ->toArray();
    }

    public static function abilitiesByResource(): array
    {
        return self::query()
            ->select(['resource', 'action'])
            ->get()
            ->groupBy('resource')
            ->mapWithKeys(function ($group, $resource) {
                $abilities = $group->map(fn($permission) => "{$resource}:{$permission->action}")
                    ->unique()
                    ->values()
                    ->toArray();
                return [$resource => $abilities];
            })
            ->toArray();
    }
}
