<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'company' => $this->company,
            'title' => $this->title,
            'manager' => $this->manager,
            'lead' => $this->lead,
            'status' => $this->status->asObject(),
            'role' => $this->role,
            'permissions' => [],
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
