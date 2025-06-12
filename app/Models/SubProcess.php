<?php

namespace App\Models;

class SubProcess extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'process_id',
        'name',
        'description',
        'status',
        'configs',
        'metas',
    ];
}
