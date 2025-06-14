<?php

namespace App\Http\Resources\Module;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuleResource extends JsonResource
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
            'status' => $this->status->asObject(),
            'configs' => $this->configs,
            'metas' => $this->metas,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'created_by_email' => $this->created_by_email,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'updated_by_email' => $this->updated_by_email,
        ];
    }
}
