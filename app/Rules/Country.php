<?php

namespace App\Rules;

use Closure;
use Nnjeim\World\World;
use Illuminate\Contracts\Validation\ValidationRule;

class Country implements ValidationRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = true;

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Ensure the value is uppercase ISO2
        $code = strtoupper($value);

        // Fetch the country by ISO2 using the World package
        $country = World::countries(['filters' => ['iso2' => $code]]);
        dd($country);
        // If no country matches, it's invalid
        if (! $country->success || empty($country->data)) {
            $fail("The selected {$attribute} is not a valid ISO2 country code.");
        }
    }
}
