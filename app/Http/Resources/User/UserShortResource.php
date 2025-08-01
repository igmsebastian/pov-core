<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShortResource extends JsonResource
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
        ];
    }
}
