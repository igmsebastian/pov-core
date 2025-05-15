<?php

namespace App\Models;

use App\Models\Concerns\Auditable;

class Permission extends Model
{
    use Auditable;

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
