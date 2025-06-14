<?php

namespace App\Http\Requests\Feature;

use App\Enums\StatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureStatusRequest extends FormRequest
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
            'feature:edit',
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
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*'   => ['required', 'string', 'distinct', Rule::exists('features', 'id')],
            'status' => ['required', Rule::in(array_column(StatusEnum::commonStatuses(), 'value'))],
        ];
    }
}
