<?php

namespace App\Models;

use Nnjeim\World\Models\Country as CountryModel;
use Nnjeim\World\World;

class Country extends CountryModel
{
    public static function getCountriesForForm(): array
    {
        $result = World::countries([
            'fields' => 'name,iso2',
        ]);

        if (! $result->success || empty($result->data)) {
            return [];
        }

        return collect($result->data)
            ->values()
            ->map(function ($country) {
                return [
                    'label' => $country['name'],
                    'value' => $country['iso2'],
                ];
            })
            ->all();
    }
}
