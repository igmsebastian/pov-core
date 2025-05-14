<?php

namespace App\Enums;

enum StatusEnum: int
{
    case ACTIVE = 1;
    case NEW = 2;
    case INACTIVE = 5;

    case COMPLETED = 11;
    case IN_PROGRESS = 13;
    case CANCELLED = 15;
    case EXPIRED = 19;

    public static function asString(): string
    {
        $values = array_column(self::cases(), 'value');
        return implode(',', $values);
    }

    public function asObject(): array
    {
        return [
            'id' => $this->value,
            'name' => strtolower($this->name),
        ];
    }
}
