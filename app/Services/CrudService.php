<?php

namespace App\Services;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class CrudService extends Service
{
    public function list(QueryFilter $filter, Model $model)
    {
        //
    }

    public function get(Model $model)
    {
        //
    }

    public function save(Model $model, array $data)
    {
        return $model::updateOrCreate($data);
    }

    public function delete(Model $model)
    {
        $model->delete();
    }
}