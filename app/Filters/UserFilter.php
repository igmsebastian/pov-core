<?php

namespace App\Filters;

use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends QueryFilter
{
    public function keyword(string $value = null): Builder
    {
        //
    }
}