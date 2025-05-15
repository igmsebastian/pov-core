<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->created_by_email = Auth::user()->email;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
                $model->updated_by_email = Auth::user()->email;
            }
        });
    }
}
