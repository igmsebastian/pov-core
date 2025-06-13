<?php

namespace App\Http\Requests\User;

use App\Rules\Permissions;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'user:*',
            'user:edit',
        ];

        foreach ($allowedPermissions as $ability) {
            if ($user->tokenCan($ability)) {
                return true;
            }
        }

        return false;
    }

    public function rules(): array
    {
        $user = $this->user;

        return [
            'samaccountname' => ['required', Rule::unique('users', 'samaccountname')->ignore($user?->id)],
            'configs' => ['required', 'array'],
            'configs.permissions'   => ['required', 'array', 'min:1'],
            'configs.permissions.*' => ['string', new Permissions],
            'configs.modules'   => ['required', 'array', 'min:1'],
            'configs.modules.*' => ['string', Rule::exists('modules', 'code')],
        ];
    }
}
