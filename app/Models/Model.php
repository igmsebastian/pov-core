<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use HasUlids;

    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }
}
