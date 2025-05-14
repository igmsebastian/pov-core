<?php

namespace App\Enums;

enum NotificationTypeEnum: int
{
    case SYSTEM = 1;
    case REMINDER = 2;

    case SUCCESS = 11;
    case WARNING = 13;
    case CANCELLED = 15;

    case DONE = 21;
    case NEW = 22;
    case FOLLOW_UP = 14;
    case MANUAL = 14;

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