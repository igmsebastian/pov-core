<?php

namespace App\Services\Abac;

use App\Services\Service;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\Permission\ListResource;
use App\Http\Resources\Rbac\PermissionResource;
use Exception;

class PermissionService extends Service
{
    public function list(Request $request)
    {
        return PermissionResource::collection($this->paginate(Permission::get()));
    }

    public function get(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->validated();
            Permission::create($data);
            return $this->sendOkResponse();
        } catch (Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage());
        }
    }

    public function update(Request $request, Permission $permission)
    {
        try {
            $data = $request->validated();
            $permission->update($data);
            return $this->sendOkResponse();
        } catch (Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage());
        }
    }

    public function delete(Permission $permission)
    {
        try {
            $permission->delete();
            return $this->sendOkResponse();
        } catch (Exception $ex) {
            return $this->sendErrorResponse($ex->getMessage());
        }
    }
}
