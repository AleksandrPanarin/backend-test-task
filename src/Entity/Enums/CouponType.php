<?php

declare(strict_types=1);

namespace App\Entity\Enums;

enum CouponType: string
{
    case FIXED_DISCOUNT = 'fixed';
    case IN_PERCENTAGE_DISCOUNT = 'percent';

    public static function values(): array
    {
        return [
            self::FIXED_DISCOUNT,
            self::IN_PERCENTAGE_DISCOUNT,
        ];
    }

    public function value(): string
    {
        return $this->value;
    }
}
