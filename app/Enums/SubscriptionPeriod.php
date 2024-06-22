<?php

namespace App\Enums;

use Ramsey\Uuid\Type\Integer;

enum SubscriptionPeriod: int{
    case Month = 1;
    case Year = 2;
    case UpgradeToYear = 3;

    // name
    public function name(): string
    {
        return match ($this->value) {
            self::Month => __('Month'),
            self::Year => __('Year'),
            self::UpgradeToYear => __('Upgrade To Year'),
        };
    }
    public static function fromCase($case)
    {
        return (new \ReflectionEnum(self::class))->getCase($case)->getValue()->value;
    }
}
