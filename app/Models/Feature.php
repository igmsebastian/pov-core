<?php

namespace App\Models;

class Feature extends Model
{
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
}
