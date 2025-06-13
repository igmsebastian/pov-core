<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
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
            'samaccountname' => $this->samaccountname,
            'company' => $this->company,
            'title' => $this->title,
            'manager' => $this->manager,
            'status' => $this->status->asObject(),
        ];
    }
}
