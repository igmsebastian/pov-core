<?php

namespace App\Models\Workflow;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model as BaseModel;


class WorkflowModel extends BaseModel
{
    use HasUlids;

    public function getConnectionName()
    {
        return config('pov.databases.wft');
    }
}
