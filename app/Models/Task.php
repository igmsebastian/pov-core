<?php

namespace App\Models;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'sub_process_id',
        'feature_id',
        'name',
        'description',
        'status',
        'configs',
        'metas',
    ];
}
