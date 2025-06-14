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
            'samaccountname' => $this->samaccountname,
            'name' => $this->name,
            'email' => $this->email,
            'title' => $this->title,
            'company' => $this->company,
            'division' => $this->division,
            'memberof' => $this->memberof,
            'department' => $this->department,
            'manager' => $this->manager,
            'manager_email' => $this->manager_email,
            'lead' => $this->lead,
            'lead_email' => $this->lead_email,
            'status' => $this->status->asObject(),
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
