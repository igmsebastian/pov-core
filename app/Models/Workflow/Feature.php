<?php

namespace App\Models\Workflow;

class Feature extends WorkflowModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'configs',
        'metas',
    ];
}
