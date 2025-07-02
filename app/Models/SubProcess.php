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
        ];
    }

    public function steps()
    {
        return $this->belongsToMany(Step::class, 'sub_process_steps')
            ->withPivot('sequence', 'is_optional', 'condition')
            ->orderBy('pivot_sequence');
    }
}
