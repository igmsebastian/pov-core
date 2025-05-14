<?php

namespace App\Enums;

enum RoleEnum: int
{
    case USER = 1;
    case MANAGER = 2;
    case ADMIN = 5;

    public static function asString(): string
    {
        $values = array_column(self::cases(), 'value');
        return implode(',', $values);
    }

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::MANAGER => 'Manager',
            self::ADMIN => 'Administrator',
        };
    }

    public function asObject(): array
    {
        return [
            'id' => $this->value,
            'name' => strtolower($this->name),
        ];
    }
}