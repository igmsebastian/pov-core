<?php

namespace App\Models;

class Process extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'module_id',
        'country',
        'name',
        'description',
        'status',
        'configs',
        'metas',
    ];
}
