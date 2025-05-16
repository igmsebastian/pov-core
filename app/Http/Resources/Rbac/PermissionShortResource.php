<?php

namespace App\Http\Resources\Rbac;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionShortResource extends JsonResource
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
            'configs' => $this->configs,
            'metas' => $this->metas
        ];
    }
}
