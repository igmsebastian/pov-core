<?php

namespace App\Enums;

enum RegionEnum: string
{
    case MENA = 'MENA';
    case APAC = 'APAC';
    case EMEA = 'EMEA';
    case LATAM = 'LATAM';
    case NA = 'NA';

    public function label(): string
    {
        return match ($this) {
            self::MENA => 'Middle East and North Africa',
            self::APAC => 'Asia-Pacific',
            self::EMEA => 'Europe, Middle East and Africa',
            self::LATAM => 'Latin America',
            self::NA => 'North America',
        };
    }
}