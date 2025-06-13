<?php

namespace App\Enums;

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case NEW = 2;
    case INACTIVE = 5;

    public static function asString(): string
    {
        $values = array_column(self::cases(), 'value');
        return implode(',', $values);
    }

    public static function options(): array {
        return array_map(
            fn(self $case) => $case->asObject(),
            self::cases()
        );
    }

    public function asObject(): array
    {
        return [
            'id' => $this->value,
            'name' => strtolower($this->name),
        ];
    }
}
