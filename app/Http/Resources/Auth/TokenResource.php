<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'expires_in' => $this->expires_in,
            'token_type' => $this->token_type,
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
        ];
    }
}
