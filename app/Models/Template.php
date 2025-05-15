<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Template extends Model
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

    protected $casts = [
        'configs' => 'array',
        'metas' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
