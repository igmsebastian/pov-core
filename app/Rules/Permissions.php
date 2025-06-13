<?php

namespace App\Rules;

use Closure;
use App\Models\Permission;
use Illuminate\Contracts\Validation\ValidationRule;

class Permissions implements ValidationRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = true;

    /**
     * Cache your valid permissions so you only hit the DB once.
     *
     * @var string[]
     */
    protected array $valid;

    public function __construct()
    {
        // Load every “resource:action” string from your permissions table
        $this->valid = Permission::allAbilities();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! in_array($value, $this->valid, true)) {
            $fail("The {$attribute} is not a valid permission.");
        }
    }
}
