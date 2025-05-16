<?php

namespace App\Http\Resources\Rbac;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'resource' => $this->resource,
            'description' => $this->description,
            'category' => $this->category,
            'scope' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'created_by_email' => $this->created_by_email,
            'updated_by' => $this->updated_by,
            'updated_by_email' => $this->updated_by_email,
            'configs' => $this->configs,
            'metas' => $this->metas
        ];
    }
}
