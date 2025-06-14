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

    public static function commonStatuses(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
        ];
    }

    public static function commonStatusesForForm(): array
    {
        return array_map(function (self $status) {
            return [
                'label' => strtolower($status->name),
                'value' => $status->value,
            ];
        }, self::commonStatuses());
    }

    public static function isCommonStatus(self $status): bool
    {
        return in_array($status, self::commonStatuses(), true);
    }

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
