<?php

namespace App\Http\Requests\Feature;

use App\Rules\Country;
use App\Enums\FeatureTypeEnum;
use App\Rules\Permissions;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        $allowedPermissions = [
            '*:*',
            'feature:*',
            'feature:create',
        ];

        foreach ($allowedPermissions as $ability) {
            if ($user->tokenCan($ability)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country' => ['required', new Country],
            'name' => ['required', Rule::unique('features', 'name')],
            'code' => ['required', Rule::unique('features', 'code')],
            'type' => ['required', Rule::in(array_column(FeatureTypeEnum::cases(), 'value'))],
            'description' => ['nullable'],
            'configs' => ['required', 'array'],
            'configs.enabled'   => ['required', 'boolean'],
            'configs.allowed_permissions'   => ['required', 'array', 'min:1'],
            'configs.allowed_permissions.*' => ['string', new Permissions],
            'configs.custom_fields' => ['nullable', 'array'],
            'configs.custom_fields.*.label' => ['nullable', 'string'],
            'configs.custom_fields.*.type' => ['nullable', 'string'],
            'configs.custom_fields.*.value' => ['nullable', 'string'],
            'configs.custom_fields.*.options' => ['nullable', 'array'],
            'configs.custom_fields.*.regex' => ['nullable', 'string'],
            'metas' => ['required', 'array'],
            'metas.visibility'   => ['required', 'boolean'],
            'metas.priority' => ['sometimes', 'nullable', 'integer'],
            'metas.order' => ['sometimes', 'nullable', 'integer'],
            'metas.icon' => ['sometimes', 'nullable', 'string'],
            'metas.hex_color' => ['sometimes', 'nullable', 'string', 'regex:/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/'],
            'metas.badge' => ['sometimes', 'nullable', 'string'],
            'metas.style' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
