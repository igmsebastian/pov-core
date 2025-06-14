<?php

namespace App\Http\Resources\Feature;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureListResource extends JsonResource
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
            'country' => $this->country,
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type->asObject(),
            'status' => $this->status->asObject(),
            'enabled' => $this->configs->enabled ?? false,
            'metas' => $this->metas,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'created_by_email' => $this->created_by_email,
            'updated_at' => $this->updated_at,
            'updated_by_email' => $this->updated_by_email,
        ];
    }
}
