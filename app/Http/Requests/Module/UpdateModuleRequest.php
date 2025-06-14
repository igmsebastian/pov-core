<?php

namespace App\Http\Requests\Module;

use App\Rules\Country;
use App\Rules\Permissions;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateModuleRequest extends FormRequest
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
            'module:*',
            'module:create',
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
            'name' => ['required', Rule::unique('modules', 'name')],
            'code' => ['required', Rule::unique('modules', 'code')],
            'description' => ['nullable'],
            'configs' => ['required', 'array'],
            'configs.enabled'   => ['required', 'boolean'],
            'configs.allowed_permissions'   => ['required', 'array', 'min:1'],
            'configs.allowed_permissions.*' => ['string', new Permissions],
            'configs.sidemenus'   => ['required', 'array', 'min:1'],
            'configs.sidemenus.*' => ['string', Rule::exists('features', 'code')],
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
