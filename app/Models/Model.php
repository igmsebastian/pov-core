<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Model extends BaseModel
{
    use HasUlids;
}
