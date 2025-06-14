<?php

namespace App\Enums;

enum FeatureTypeEnum: int
{
    case MENU = 1;
    case FEATURE = 2;

    public static function asString(): string
    {
        $values = array_column(self::cases(), 'value');
        return implode(',', $values);
    }

    public static function forForm(): array
    {
        return array_map(function (self $status) {
            return [
                'label' => strtolower($status->name),
                'value' => $status->value,
            ];
        }, self::cases());
    }

    public function asObject(): array
    {
        return [
            'id' => $this->value,
            'name' => strtolower($this->name),
        ];
    }
}
