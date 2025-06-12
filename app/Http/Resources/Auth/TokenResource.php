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
        $token = $this->resource;
        $accessToken = $token->accessToken;
        $model = $accessToken->tokenable_type;
        $user = (new $model)->find($accessToken->tokenable_id);

        return [
            'token' => $token->plainTextToken,
            'tokenableType' => $accessToken->tokenable_type,
            'abilities' => $accessToken->abilities,
            'expires_at' => $accessToken->expires_at,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'configs' => $user->configs,
                'metas' => $user->metas
            ]
        ];
    }
}
