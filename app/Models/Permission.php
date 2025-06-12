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
}
