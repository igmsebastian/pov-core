<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'country',
        'feature_id',
        'process_id',
        'sub_process_id',
        'name',
        'label',
        'exec_type',
        'exec',
        'description',
        'status',
        'configs',
        'metas',
        'logs',
        'created_by',
        'created_by_email',
        'updated_by',
        'updated_by_email',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'configs' => 'array',
            'metas' => 'array',
            'logs' => 'array',
        ];
    }
}
